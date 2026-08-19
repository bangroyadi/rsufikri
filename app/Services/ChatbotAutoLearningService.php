<?php

namespace App\Services;

use App\Models\KnowledgeBase;
use App\Models\ChatbotUnrecognizedQuery;
use App\Models\Doctor;
use App\Models\Polyclinic;
use App\Models\Service;
use Illuminate\Support\Str;

class ChatbotAutoLearningService
{
    protected SmartAssistantService $assistantService;

    public function __construct(SmartAssistantService $assistantService)
    {
        $this->assistantService = $assistantService;
    }

    /**
     * Memproses seluruh antrean pertanyaan yang belum terselesaikan secara otomatis
     */
    public function processPendingQueries(): array
    {
        $pendingQueries = ChatbotUnrecognizedQuery::where('is_resolved', false)->get();

        $stats = [
            'total'        => $pendingQueries->count(),
            'spam_cleaned' => 0,
            'auto_mapped'  => 0,
            'skipped'      => 0,
        ];

        if ($pendingQueries->isEmpty()) {
            return $stats;
        }

        $allKb = KnowledgeBase::where('is_active', true)->get();

        foreach ($pendingQueries as $query) {
            $raw = trim($query->raw_query);
            $normalized = $this->assistantService->normalizeText($raw);
            $tokens = $this->assistantService->tokenizeAndExpand($normalized);

            // 1. FILTER SPAM / KARAKTER TIDAK BERMAKNA
            if ($this->isSpamQuery($raw, $normalized)) {
                $query->update([
                    'is_resolved'  => true,
                    'admin_notes'  => '🧹 Dibersihkan otomatis oleh sistem (Spam / Teks acak)',
                ]);
                $stats['spam_cleaned']++;
                continue;
            }

            // 2. CEK APAKAH QUERY MENYEBUT NAMA DOKTER / POLI / LAYANAN MASTER
            $matchedMaster = $this->matchMasterData($normalized);
            if ($matchedMaster) {
                $query->update([
                    'is_resolved'      => true,
                    'detected_intent'  => $matchedMaster['intent'],
                    'confidence_score' => 95.0,
                    'admin_notes'      => "🏥 Otomatis dikenali dari data master RS ({$matchedMaster['name']})",
                ]);
                $stats['auto_mapped']++;
                continue;
            }

            // 3. CEK APAKAH QUERY MERUPAKAN KONSULTASI / GEJALA MEDIS
            $medicalKeywords = ['batuk', 'mual', 'pusing', 'sakit', 'demam', 'nyeri', 'sesak', 'muntah', 'diare', 'flu', 'pilek', 'gatal', 'luka', 'darah', 'lambung', 'infeksi'];
            $isMedical = false;
            foreach ($medicalKeywords as $mk) {
                if (str_contains($normalized, $mk)) {
                    $isMedical = true;
                    break;
                }
            }

            if ($isMedical) {
                $medicalKb = $allKb->where('intent', 'medical_disclaimer')->first() ?: $allKb->where('intent', 'complaint')->first();
                if ($medicalKb) {
                    $this->appendSynonymToKb($medicalKb, $raw, $normalized);
                    $query->update([
                        'is_resolved'      => true,
                        'detected_intent'  => $medicalKb->intent,
                        'confidence_score' => 90.0,
                        'admin_notes'      => "🩺 Otomatis diklasifikasikan ke Edukasi & Rujukan Medis ({$medicalKb->intent})",
                    ]);
                    $stats['auto_mapped']++;
                    continue;
                }
            }

            // 4. CEK FASILITAS / PERTANYAAN UMUM
            if (str_contains($normalized, 'fasilitas') || str_contains($normalized, 'parkir') || str_contains($normalized, 'helipad') || str_contains($normalized, 'lantai') || str_contains($normalized, 'kantin') || str_contains($normalized, 'mushola') || str_contains($normalized, 'atm')) {
                $facilityKb = $allKb->where('intent', 'facilities')->first() ?: $allKb->where('intent', 'hospital_profile')->first();
                if ($facilityKb) {
                    $this->appendSynonymToKb($facilityKb, $raw, $normalized);
                    $query->update([
                        'is_resolved'      => true,
                        'detected_intent'  => $facilityKb->intent,
                        'confidence_score' => 85.0,
                        'admin_notes'      => "🏢 Otomatis diklasifikasikan ke Fasilitas & Profil RS ({$facilityKb->intent})",
                    ]);
                    $stats['auto_mapped']++;
                    continue;
                }
            }

            // 5. AUTO-ASSOCIATION KE KNOWLEDGE BASE TERDEKAT
            $bestMatch = null;
            $highestScore = 0;

            foreach ($allKb as $kb) {
                $kbTokens = $this->assistantService->tokenizeAndExpand(
                    $this->assistantService->normalizeText($kb->question . ' ' . $kb->keywords . ' ' . $kb->synonyms)
                );

                $intersection = array_intersect($tokens, $kbTokens);
                if (count($intersection) > 0) {
                    $overlapRatio = count($intersection) / max(1, count($tokens));
                    $score = $overlapRatio * 100;

                    if ($score > $highestScore) {
                        $highestScore = $score;
                        $bestMatch = $kb;
                    }
                }
            }

            // Jika kemiripan di atas 35%, otomatis tambahkan ke synonyms Knowledge Base
            if ($bestMatch && $highestScore >= 35) {
                $this->appendSynonymToKb($bestMatch, $raw, $normalized);

                $query->update([
                    'is_resolved'      => true,
                    'detected_intent'  => $bestMatch->intent,
                    'confidence_score' => round($highestScore, 1),
                    'admin_notes'      => "🧠 Otomatis diasosiasikan ke topik: {$bestMatch->question} ({$bestMatch->intent})",
                ]);

                $stats['auto_mapped']++;
            } else {
                $stats['skipped']++;
            }
        }

        return $stats;
    }

    /**
     * Cek apakah teks merupakan spam / karakter acak
     */
    public function isSpamQuery(string $raw, string $normalized): bool
    {
        $len = strlen(trim($raw));
        if ($len < 3) return true;

        // Cek karakter acak berulang (misal: "aaaaa", "11111")
        if (preg_match('/(.)\1{2,}/', $normalized)) return true;

        // Kata-kata testing umum tanpa makna
        $spamWords = ['tes', 'test', 'testing', 'ping', 'pong', 'asdf', 'qwerty', 'zxcv', 'coba', 'halo tes', 'cek', 'p', 'pp'];
        if (in_array($normalized, $spamWords)) return true;

        // Hanya karakter angka atau simbol tanpa huruf
        if (!preg_match('/[a-zA-Z]/', $raw)) return true;

        // Keyboard mash: String tanpa spasi panjang >= 7 dengan 5+ konsonan berturut-turut tanpa vokal
        if (!str_contains($normalized, ' ') && strlen($normalized) >= 7) {
            if (preg_match('/[bcdfghjklmnpqrstvwxyz0-9]{5,}/i', $normalized)) {
                return true;
            }
        }

        // Teks acak keyboard mash seperti "asdf", "hjkl", "ghjk"
        if (preg_match('/(asdf|dfgh|ghjk|hjkl|qwerty|zxcv)/i', $normalized)) {
            return true;
        }

        return false;
    }

    /**
     * Cocokkan dengan data master Dokter, Poliklinik, dan Layanan
     */
    protected function matchMasterData(string $normalized): ?array
    {
        // 1. Poliklinik
        $polis = Polyclinic::where('is_active', true)->get();
        foreach ($polis as $p) {
            $pName = strtolower(is_array($p->name) ? ($p->name['id'] ?? '') : $p->name);
            $slug = str_replace('-', ' ', strtolower($p->slug));
            if (str_contains($normalized, $pName) || str_contains($normalized, $slug)) {
                return ['type' => 'poli', 'name' => $pName, 'intent' => 'doctor_schedule'];
            }
        }

        // 2. Dokter
        $doctors = Doctor::where('is_active', true)->get();
        foreach ($doctors as $d) {
            $docName = strtolower(str_replace(['dr.', 'sp.', 'drg.'], '', $d->name));
            $words = explode(' ', trim($docName));
            foreach ($words as $w) {
                if (strlen($w) >= 4 && str_contains($normalized, $w)) {
                    return ['type' => 'doctor', 'name' => $d->name, 'intent' => 'doctor_schedule'];
                }
            }
        }

        // 3. Layanan
        $services = Service::where('is_active', true)->get();
        foreach ($services as $s) {
            $sName = strtolower(is_array($s->name) ? ($s->name['id'] ?? '') : $s->name);
            if (str_contains($normalized, $sName)) {
                return ['type' => 'service', 'name' => $sName, 'intent' => 'service_search'];
            }
        }

        return null;
    }

    /**
     * Tambahkan frasa kalimat baru ke kolom synonyms Knowledge Base tanpa duplikasi
     */
    protected function appendSynonymToKb(KnowledgeBase $kb, string $rawPhrase, string $normalizedPhrase): void
    {
        $existingSynonyms = array_map('trim', explode(',', $kb->synonyms ?? ''));
        $existingSynonyms = array_filter($existingSynonyms);

        if (!in_array($normalizedPhrase, array_map('strtolower', $existingSynonyms))) {
            $existingSynonyms[] = $normalizedPhrase;
            $kb->synonyms = implode(', ', array_unique($existingSynonyms));
            $kb->save();
        }
    }
}
