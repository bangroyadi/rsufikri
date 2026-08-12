<?php

namespace App\Services;

use App\Models\KnowledgeBase;
use Illuminate\Support\Collection;

class SmartAssistantService
{
    /**
     * Peta sinonim & variasi kata umum bahasa Indonesia / medis
     */
    protected array $synonymMap = [
        'gimana'       => 'cara',
        'bagaimana'    => 'cara',
        'gmn'          => 'cara',
        'jln'          => 'jalan',
        'dok'          => 'dokter',
        'dr'           => 'dokter',
        'praktek'      => 'praktik',
        'prakteknya'   => 'praktik',
        'opname'       => 'inap',
        'ugd'          => 'igd',
        'emergency'    => 'igd',
        'darurat'      => 'igd',
        'ambulans'     => 'igd',
        'ambulance'    => 'igd',
        'checkup'      => 'mcu',
        'check-up'     => 'mcu',
        'periksa'      => 'pemeriksaan',
        'berobat'      => 'daftar',
        'registrasi'   => 'daftar',
        'pendaftaran'  => 'daftar',
        'syarat'       => 'persyaratan',
        'berkas'       => 'persyaratan',
        'kis'          => 'bpjs',
        'jkn'          => 'bpjs',
        'dimana'       => 'lokasi',
        'alamat'       => 'lokasi',
        'peta'         => 'lokasi',
        'maps'         => 'lokasi',
        'no'           => 'telepon',
        'nomor'        => 'telepon',
        'wa'           => 'whatsapp',
        'hp'           => 'telepon',
        'kontak'       => 'telepon',
        'biaya'        => 'tarif',
        'harga'        => 'tarif',
    ];

    /**
     * Kata-kata pemberhenti (stopwords) yang tidak memiliki arti penting untuk pencocokan intent
     */
    protected array $stopwords = [
        'di', 'ke', 'dari', 'yang', 'dan', 'atau', 'ini', 'itu', 'pada', 'dengan', 
        'untuk', 'ada', 'bisa', 'saya', 'kami', 'kita', 'anda', 'kamu', 'apa', 
        'siapa', 'mengapa', 'kenapa', 'kapan', 'kah', 'lah', 'pun', 'dong', 'ya', 
        'tolong', 'mau', 'ingin', 'tolong', 'kasih', 'tahu', 'informasi', 'infonya'
    ];

    /**
     * Proses utama pencarian jawaban terbaik berdasarkan kueri pengguna
     */
    public function processQuery(string $rawQuery): array
    {
        $normalizedQuery = $this->normalizeText($rawQuery);
        $queryTokens = $this->tokenizeAndExpand($normalizedQuery);

        // 1. Cek keamanan medis (jika ada indikasi pertanyaan diagnosis / rekomendasi obat)
        if ($this->isMedicalConsultationQuery($queryTokens, $normalizedQuery)) {
            $medisKb = KnowledgeBase::where('intent', 'konsultasi_medis')->where('is_active', true)->first();
            if ($medisKb) {
                return [
                    'found'      => true,
                    'intent'     => $medisKb->intent,
                    'score'      => 1.0,
                    'answer'     => $medisKb->answer,
                    'is_fallback' => false,
                ];
            }
        }

        // 2. Ambil seluruh data Knowledge Base yang aktif
        $allKb = KnowledgeBase::where('is_active', true)->get();

        if ($allKb->isEmpty()) {
            return $this->buildFallbackResponse();
        }

        // 3. Hitung Skor Kemiripan (Similarity Scoring) untuk tiap item KB
        $bestMatch = null;
        $highestScore = 0.0;

        foreach ($allKb as $kb) {
            $score = $this->calculateSimilarityScore($normalizedQuery, $queryTokens, $kb);

            if ($score > $highestScore) {
                $highestScore = $score;
                $bestMatch = $kb;
            }
        }

        // 4. Ambang Batas Kepercayaan (Confidence Threshold = 0.28)
        if ($bestMatch && $highestScore >= 0.28) {
            return [
                'found'       => true,
                'intent'      => $bestMatch->intent,
                'score'       => round($highestScore, 2),
                'answer'      => $bestMatch->answer,
                'is_fallback' => false,
            ];
        }

        // 5. Fallback jika tidak menemukan jawaban yang cukup meyakinkan
        return $this->buildFallbackResponse();
    }

    /**
     * Normalisasi teks: lowercase, hapus tanda baca, bersihkan spasi ganda
     */
    public function normalizeText(string $text): string
    {
        $text = mb_strtolower($text, 'UTF-8');
        // Hapus tanda baca
        $text = preg_replace('/[^\w\s]/u', ' ', $text);
        // Hapus spasi berlebih
        $text = preg_replace('/\s+/', ' ', $text);
        return trim($text);
    }

    /**
     * Tokenisasi & Ekspansi Sinonim
     */
    public function tokenizeAndExpand(string $normalizedText): array
    {
        $words = explode(' ', $normalizedText);
        $tokens = [];

        foreach ($words as $word) {
            $word = trim($word);
            if (empty($word) || strlen($word) < 2) continue;

            // Abaikan stopwords
            if (in_array($word, $this->stopwords)) {
                continue;
            }

            // Tambahkan kata asli
            $tokens[] = $word;

            // Jika ada sinonimnya, tambahkan sinonim standar
            if (isset($this->synonymMap[$word])) {
                $tokens[] = $this->synonymMap[$word];
            }
        }

        return array_values(array_unique($tokens));
    }

    /**
     * Deteksi apakah kueri berhubungan dengan konsultasi obat / diagnosis medis
     */
    protected function isMedicalConsultationQuery(array $queryTokens, string $normalizedQuery): bool
    {
        $symptomKeywords = ['sakit', 'nyeri', 'mual', 'muntah', 'demam', 'pusing', 'batuk', 'sesak', 'diare', 'bengkak', 'luka', 'gatal', 'resep', 'obat'];
        
        $matchCount = 0;
        foreach ($symptomKeywords as $symptom) {
            if (in_array($symptom, $queryTokens) || str_contains($normalizedQuery, $symptom)) {
                $matchCount++;
            }
        }

        // Jika terdapat minimal 2 kata gejala / keluhan obat
        return $matchCount >= 2 || (in_array('obat', $queryTokens) && in_array('sakit', $queryTokens));
    }

    /**
     * Kalkulasi Skor Kemiripan Kombinasi:
     * - Keyword & Synonym Overlap (Bobot 50%)
     * - Jaccard Coefficient (Bobot 30%)
     * - Fuzzy Matching (Levenshtein / similar_text) (Bobot 20%)
     */
    protected function calculateSimilarityScore(string $normalizedQuery, array $queryTokens, KnowledgeBase $kb): float
    {
        if (empty($queryTokens)) return 0.0;

        // Persiapan data target KB
        $kbQuestionNorm = $this->normalizeText($kb->question);
        $kbKeywordsNorm = $this->normalizeText(($kb->keywords ?? '') . ' ' . ($kb->synonyms ?? ''));

        $targetTextCombined = $kbQuestionNorm . ' ' . $kbKeywordsNorm;
        $kbTokens = $this->tokenizeAndExpand($targetTextCombined);

        if (empty($kbTokens)) return 0.0;

        // 1. Keyword & Synonym Overlap Score
        $matchedCount = 0;
        foreach ($queryTokens as $qToken) {
            if (in_array($qToken, $kbTokens) || str_contains($targetTextCombined, $qToken)) {
                $matchedCount++;
            }
        }
        $keywordScore = $matchedCount / count($queryTokens);

        // 2. Jaccard Similarity Coefficient (|A ∩ B| / |A ∪ B|)
        $intersection = array_intersect($queryTokens, $kbTokens);
        $union = array_unique(array_merge($queryTokens, $kbTokens));
        $jaccardScore = count($union) > 0 ? (count($intersection) / count($union)) : 0;

        // 3. Fuzzy Matching (Levenshtein & similar_text untuk typo)
        $fuzzyScore = 0.0;
        similar_text($normalizedQuery, $kbQuestionNorm, $simPercent);
        $fuzzyScore = $simPercent / 100.0;

        // Juga periksa fuzzy terhadap keywords
        foreach ($queryTokens as $qToken) {
            foreach ($kbTokens as $kbToken) {
                $lev = levenshtein($qToken, $kbToken);
                if ($lev <= 2 && strlen($qToken) > 3) {
                    $fuzzyScore += 0.15;
                    break;
                }
            }
        }
        $fuzzyScore = min(1.0, $fuzzyScore);

        // 4. Bobot Gabungan
        $finalScore = ($keywordScore * 0.50) + ($jaccardScore * 0.30) + ($fuzzyScore * 0.20);

        // Tambahan sedikit poin untuk prioritas
        if ($kb->priority > 0) {
            $finalScore += ($kb->priority * 0.005);
        }

        return min(1.0, $finalScore);
    }

    /**
     * Membangun respons fallback yang ramah dan solutif
     */
    public function buildFallbackResponse(): array
    {
        return [
            'found'       => false,
            'intent'      => 'fallback',
            'score'       => 0.0,
            'answer'      => 'Maaf, Tanya Fikri belum menemukan informasi yang persis sama dengan pertanyaan Anda. 🙏<br><br>Anda dapat memilih salah satu topik populer berikut atau melihat menu informasi yang tersedia:',
            'is_fallback' => true,
            'suggestions' => [
                ['label' => '📅 Jadwal Dokter', 'url' => '/jadwal-dokter'],
                ['label' => '🏥 Pelayanan RS', 'url' => '/#layanan'],
                ['label' => '📋 Syarat BPJS', 'query' => 'Persyaratan BPJS Kesehatan'],
                ['label' => '🚨 Nomor IGD 24 Jam', 'query' => 'Nomor IGD 24 jam'],
                ['label' => '📍 Lokasi & Kontak', 'url' => '/kontak'],
            ],
        ];
    }
}
