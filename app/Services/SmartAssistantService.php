<?php

namespace App\Services;

use App\Models\KnowledgeBase;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Polyclinic;
use App\Models\Service;
use App\Models\HospitalProfile;
use App\Models\ChatbotUnrecognizedQuery;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class SmartAssistantService
{
    /**
     * Peta sinonim & variasi kata bahasa Indonesia / istilah medis rumah sakit
     */
    protected array $synonymMap = [
        'kpn'           => 'kapan',
        'bukanya'       => 'buka',
        'bukan'         => 'buka',
        'pagi'          => 'pagi',
        'mlm'           => 'malam',
        'brapa'         => 'berapa',
        'brp'           => 'berapa',
        'dftr'          => 'daftar',
        'onlin'         => 'online',
        'matau'         => 'mata',
        'matah'         => 'mata',
        'gimana'        => 'cara',
        'bagaimana'     => 'cara',
        'gmn'           => 'cara',
        'jln'           => 'jalan',
        'dok'           => 'dokter',
        'dr'            => 'dokter',
        'doktr'         => 'dokter',
        'praktek'       => 'praktik',
        'prakteknya'    => 'praktik',
        'opname'        => 'inap',
        'rawatinap'     => 'rawat inap',
        'rawatjalan'    => 'rawat jalan',
        'ugd'           => 'igd',
        'emergency'     => 'igd',
        'darurat'       => 'igd',
        'ambulans'      => 'ambulans',
        'ambulance'     => 'ambulans',
        'checkup'       => 'mcu',
        'check-up'      => 'mcu',
        'cekup'         => 'mcu',
        'periksa'       => 'pemeriksaan',
        'berobat'       => 'daftar',
        'registrasi'    => 'daftar',
        'pendaftaran'   => 'daftar',
        'syarat'        => 'persyaratan',
        'berkas'        => 'persyaratan',
        'kis'           => 'bpjs',
        'jkn'           => 'bpjs',
        'bpjstk'        => 'bpjs ketenagakerjaan',
        'bpjs-tk'       => 'bpjs ketenagakerjaan',
        'dimana'        => 'lokasi',
        'dmana'         => 'lokasi',
        'alamat'        => 'lokasi',
        'peta'          => 'lokasi',
        'maps'          => 'lokasi',
        'no'            => 'telepon',
        'nomor'         => 'telepon',
        'wa'            => 'whatsapp',
        'hp'            => 'telepon',
        'kontak'        => 'telepon',
        'biaya'         => 'tarif',
        'harga'         => 'tarif',
        'ongkos'        => 'tarif',
        'bayar'         => 'tarif',
        'katarak'       => 'mata',
        'eracs'         => 'kemilau cinta',
        'usg'           => 'usg',
        'spog'          => 'kandungan',
        'obgyn'         => 'kandungan',
        'pediatri'      => 'anak',
        'internis'      => 'penyakit dalam',
        'kardiologi'    => 'jantung',
        'pulmonologi'   => 'paru',
        'neurologi'     => 'saraf',
        'tht'           => 'tht',
        'gigi'          => 'gigi',
    ];

    /**
     * Stopwords (kata umum tanpa arti penting pencocokan)
     */
    protected array $stopwords = [
        'di', 'ke', 'dari', 'yang', 'dan', 'atau', 'ini', 'itu', 'pada', 'dengan', 
        'untuk', 'ada', 'bisa', 'saya', 'kami', 'kita', 'anda', 'kamu', 'apa', 
        'siapa', 'mengapa', 'kenapa', 'kapan', 'kah', 'lah', 'pun', 'dong', 'ya', 
        'tolong', 'mau', 'ingin', 'kasih', 'tahu', 'informasi', 'infonya', 'nggak',
        'tidak', 'ga', 'gak', 'bukan', 'kalau', 'kalo', 'apakah', 'adakah'
    ];

    /**
     * Daftar nama hari dalam bahasa Indonesia & mapping
     */
    protected array $dayNames = [
        'senin'  => 'Senin',
        'selasa' => 'Selasa',
        'rabu'   => 'Rabu',
        'kamis'  => 'Kamis',
        'jumat'  => 'Jumat',
        'sabtu'  => 'Sabtu',
        'minggu' => 'Minggu',
    ];

    /**
     * Daftar spesialisasi poliklinik dan kata kuncinya (diurutkan frasa spesifik lebih dahulu)
     */
    protected array $specialties = [
        'spesialis gigi (periodonti)' => ['poli spesialis gigi (periodonti)', 'spesialis gigi periodonti', 'periodonti', 'dokter gigi spesialis periodonti', 'sp.perio', 'gusi berdarah', 'periodontitis', 'karang gigi mendalam'],
        'bedah mulut'                 => ['poli bedah mulut', 'dokter bedah mulut', 'spesialis bedah mulut', 'bedah mulut', 'sp.bm', 'odontektomi', 'cabut gigi bungsu', 'fraktur rahang', 'kista mulut'],
        'bedah saraf'                 => ['poli bedah saraf', 'dokter bedah saraf', 'spesialis bedah saraf', 'bedah saraf', 'sp.bs', 'operasi saraf', 'operasi otak', 'tumor otak', 'trauma kepala'],
        'kulit dan kelamin'           => ['poli kulit dan kelamin', 'poli kulit', 'dokter kulit', 'spesialis kulit', 'kulit dan kelamin', 'dermatologi', 'sp.kk', 'sp.dv', 'alergi kulit', 'jerawat', 'eksim'],
        'rehab medik'                 => ['poli rehab medik', 'rehab medik', 'rehabilitasi medik', 'dokter rehab medik', 'sp.kfr', 'fisioterapi', 'terapi fisik', 'okupasi terapi'],
        'neurologi (saraf)'           => ['poli saraf', 'poli neurologi', 'dokter saraf', 'dokter neurologi', 'spesialis saraf', 'spesialis neurologi', 'neurologi', 'saraf', 'sp.s', 'sp.n', 'stroke', 'vertigo', 'migrain', 'saraf terjepit', 'hnp', 'epilepsi'],
        'tht – kl'                    => ['poli tht - kl', 'poli tht kl', 'poli tht', 'dokter tht', 'spesialis tht', 'tht – kl', 'tht - kl', 'tht kl', 'tht', 'sp.tht', 'telinga', 'hidung', 'tenggorokan', 'amandel', 'sinusitis', 'polip'],
        'penyakit dalam'              => ['poli penyakit dalam', 'dokter penyakit dalam', 'spesialis penyakit dalam', 'penyakit dalam', 'internis', 'sp.pd', 'lambung', 'maag', 'diabetes', 'ginjal', 'hati'],
        'obgyn (kandungan)'           => ['poli obgyn', 'poli kandungan', 'poli kebidanan', 'dokter kandungan', 'dokter obgyn', 'spesialis kandungan', 'kandungan', 'kebidanan', 'obgyn', 'sp.og', 'spog', 'hamil', 'melahirkan', 'persalinan', 'usg 4d'],
        'orthopedi'                   => ['poli orthopedi', 'poli ortopedi', 'dokter orthopedi', 'dokter ortopedi', 'spesialis orthopedi', 'orthopedi', 'ortopedi', 'sp.ot', 'tulang', 'patah tulang', 'sendi', 'dislokasi', 'trauma tulang'],
        'urologi'                     => ['poli urologi', 'dokter urologi', 'spesialis urologi', 'urologi', 'sp.u', 'saluran kemih', 'batu ginjal', 'prostat', 'kandung kemih', 'kencing'],
        'jantung'                     => ['poli jantung', 'dokter jantung', 'spesialis jantung', 'jantung', 'kardiologi', 'sp.jp', 'ekg', 'pembuluh darah', 'echo', 'treadmill'],
        'bedah'                       => ['poli bedah umum', 'poli bedah', 'dokter bedah', 'spesialis bedah', 'bedah umum', 'bedah', 'sp.b', 'operasi', 'usus buntu', 'hernia'],
        'paru'                        => ['poli paru', 'dokter paru', 'spesialis paru', 'paru', 'pulmonologi', 'sp.p', 'tb', 'tbc', 'asma', 'sesak nafas', 'bronkitis'],
        'mata'                        => ['poli mata', 'dokter mata', 'spesialis mata', 'mata', 'sp.m', 'katarak', 'minus', 'silinder', 'glaukoma', 'phaco'],
        'anak'                        => ['poli anak', 'dokter anak', 'spesialis anak', 'anak', 'pediatri', 'sp.a', 'bayi', 'balita', 'imunisasi', 'tumbuh kembang'],
        'jiwa'                        => ['poli jiwa', 'poli psikiatri', 'dokter jiwa', 'dokter psikiatri', 'spesialis psikiatri', 'jiwa', 'psikiatri', 'sp.kj', 'psikiater', 'kesehatan jiwa', 'depresi', 'stres', 'anxiety', 'insomnia'],
        'gigi'                        => ['poli gigi', 'dokter gigi', 'gigi', 'cabut gigi', 'tambal gigi', 'kawat gigi', 'orthodonti', 'scaling', 'saluran akar', 'karies'],
        'radiologi'                   => ['poli radiologi', 'radiologi', 'dokter radiologi', 'spesialis radiologi', 'sp.rad', 'rontgen', 'x-ray', 'xray', 'usg', 'panoramic', 'ct scan'],
    ];

    /**
     * Titik Masuk Utama Pemrosesan Pertanyaan
     */
    public function processQuery(string $rawQuery, ?string $sessionId = null): array
    {
        $rawQuery = trim($rawQuery);
        if (empty($rawQuery)) {
            return $this->buildFallbackResponse('', $sessionId);
        }

        $sessionId = $sessionId ?: Session::getId();
        $normalizedQuery = $this->normalizeText($rawQuery);
        $tokens = $this->tokenizeAndExpand($normalizedQuery);

        // 1. CEK KEAMANAN MEDIS (MEDICAL SAFETY GUARDRAIL)
        if ($this->isMedicalConsultationQuery($tokens, $normalizedQuery)) {
            return $this->buildMedicalSafetyResponse();
        }

        // 2. DETEKSI ENTITAS (Specialty, Day, Doctor, Service)
        $entities = $this->extractEntities($normalizedQuery, $tokens);

        // 3. RESOLUSI KONTEKS PERCAKAPAN (Context Tracking)
        $context = $this->resolveContext($entities, $normalizedQuery);

        // 4. CEK INTENT KHUSUS DOKTER / POLIKLINIK / JADWAL (LIVE DATABASE QUERY)
        if ($this->isDoctorQuery($normalizedQuery, $tokens, $context)) {
            $dbDoctorResponse = $this->queryLiveDoctorDatabase($context, $rawQuery);
            if ($dbDoctorResponse) {
                // Simpan context untuk percakapan berikutnya
                $this->saveContext($context);
                return $dbDoctorResponse;
            }
        }

        // 5. PENCOCOKAN KNOWLEDGE BASE BERBOBOT + FUZZY MATCHING
        $allKb = KnowledgeBase::where('is_active', true)->get();
        $matchResults = [];

        foreach ($allKb as $kb) {
            $score = $this->calculateWeightedScore($normalizedQuery, $tokens, $kb);
            if ($score > 0) {
                $matchResults[] = [
                    'kb'    => $kb,
                    'score' => $score,
                ];
            }
        }

        // Urutkan berdasarkan skor tertinggi
        usort($matchResults, fn($a, $b) => $b['score'] <=> $a['score']);
        $bestMatch = $matchResults[0] ?? null;

        // 6. EVALUASI CONFIDENCE SCORE
        if ($bestMatch && $bestMatch['score'] >= 60) {
            // HIGH CONFIDENCE: Jawaban langsung
            $kb = $bestMatch['kb'];
            
            // Perbarui context
            $context['last_intent'] = $kb->intent;
            $context['last_category'] = $kb->category;
            $this->saveContext($context);

            return [
                'found'       => true,
                'intent'      => $kb->intent,
                'score'       => round($bestMatch['score'], 1),
                'answer'      => $this->enrichAnswerWithHospitalData($kb->answer, $kb->intent),
                'is_fallback' => false,
                'buttons'     => $this->getIntentActionButtons($kb->intent),
                'suggestions' => $this->getIntentSuggestedFollowups($kb->intent),
            ];
        }

        if ($bestMatch && $bestMatch['score'] >= 40) {
            // MODERATE CONFIDENCE (40 - 59): Konfirmasi ramah
            $kb = $bestMatch['kb'];
            return [
                'found'       => true,
                'intent'      => 'confirmation_' . $kb->intent,
                'score'       => round($bestMatch['score'], 1),
                'answer'      => 'Apakah yang Anda maksud adalah informasi mengenai <strong>' . htmlspecialchars($kb->question) . '</strong>? 😊<br><br>' . $this->enrichAnswerWithHospitalData($kb->answer, $kb->intent),
                'is_fallback' => false,
                'buttons'     => $this->getIntentActionButtons($kb->intent),
                'suggestions' => $this->getIntentSuggestedFollowups($kb->intent),
            ];
        }

        // 7. LOW CONFIDENCE / UNKNOWN QUESTION: Catat ke Database & Fallback Ramah
        $this->logUnrecognizedQuery($rawQuery, $normalizedQuery, $sessionId, $bestMatch['score'] ?? 0, $bestMatch['kb']->intent ?? 'unknown');
        
        return $this->buildFallbackResponse($rawQuery, $sessionId);
    }

    /**
     * Normalisasi teks: lowercase, hapus tanda baca khusus, bersihkan spasi
     */
    public function normalizeText(string $text): string
    {
        $text = mb_strtolower($text, 'UTF-8');
        $text = preg_replace('/[^\w\s\-]/u', ' ', $text);
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

            if (in_array($word, $this->stopwords)) {
                continue;
            }

            $tokens[] = $word;

            if (isset($this->synonymMap[$word])) {
                $tokens[] = $this->synonymMap[$word];
            }
        }

        return array_values(array_unique($tokens));
    }

    /**
     * Ekstraksi Entitas (Spesialisasi, Hari, Layanan, Dokter)
     */
    protected function extractEntities(string $normalizedQuery, array $tokens): array
    {
        $entities = [
            'specialty' => null,
            'day'       => null,
            'service'   => null,
            'doctor'    => null,
        ];

        // 1. Ekstraksi Spesialisasi (Cari kecocokan terpanjang)
        $matchedSpec = null;
        $maxMatchLen = 0;

        foreach ($this->specialties as $specKey => $keywords) {
            foreach ($keywords as $kw) {
                if (str_contains($normalizedQuery, $kw)) {
                    $kwLen = strlen($kw);
                    if ($kwLen > $maxMatchLen) {
                        $maxMatchLen = $kwLen;
                        $matchedSpec = $specKey;
                    }
                }
            }
        }
        $entities['specialty'] = $matchedSpec;

        // 2. Ekstraksi Hari / Tanggal Relatif
        if (str_contains($normalizedQuery, 'hari ini') || str_contains($normalizedQuery, 'skrg') || str_contains($normalizedQuery, 'sekarang')) {
            $entities['day'] = $this->getTodayDayName();
        } elseif (str_contains($normalizedQuery, 'besok')) {
            $entities['day'] = $this->getTomorrowDayName();
        } else {
            foreach ($this->dayNames as $dayKey => $dayLabel) {
                if (str_contains($normalizedQuery, $dayKey)) {
                    $entities['day'] = $dayLabel;
                    break;
                }
            }
        }

        // 3. Ekstraksi Layanan Spesifik
        $serviceKeywords = [
            'mcu'           => 'mcu',
            'rawat inap'    => 'rawat_inap',
            'rawat jalan'   => 'rawat_jalan',
            'igd'           => 'igd',
            'kemilau cinta' => 'kemilau_cinta',
            'trauma center' => 'trauma_center',
            'lab'           => 'laboratory',
            'radiologi'     => 'radiology',
            'farmasi'       => 'pharmacy',
            'ambulans'      => 'ambulance',
        ];

        foreach ($serviceKeywords as $kw => $serviceId) {
            if (str_contains($normalizedQuery, $kw)) {
                $entities['service'] = $serviceId;
                break;
            }
        }

        // 4. Ekstraksi Nama Dokter
        $activeDoctors = Doctor::where('is_active', true)->select('id', 'name')->get();
        foreach ($activeDoctors as $doc) {
            $cleanDocName = $this->normalizeText(str_replace(['dr.', 'sp.', 'drg.'], '', $doc->name));
            $docWords = explode(' ', $cleanDocName);
            foreach ($docWords as $w) {
                if (strlen($w) >= 4 && str_contains($normalizedQuery, $w)) {
                    $entities['doctor'] = $doc;
                    break 2;
                }
            }
        }

        return $entities;
    }

    /**
     * Resolusi Konteks Percakapan menggunakan Session
     */
    protected function resolveContext(array $entities, string $normalizedQuery): array
    {
        $sessionContext = Session::get('fikri_chat_context', [
            'last_intent'    => null,
            'last_specialty' => null,
            'last_service'   => null,
            'last_doctor_id' => null,
            'last_day'       => null,
        ]);

        // Cek pertanyaan rujukan konteks (misal: "jadwalnya kapan?", "ada siapa aja?", "saya mau daftar", "iya")
        $isContextReference = (
            str_contains($normalizedQuery, 'jadwal') ||
            str_contains($normalizedQuery, 'siapa') ||
            str_contains($normalizedQuery, 'kapan') ||
            str_contains($normalizedQuery, 'daftar') ||
            $normalizedQuery === 'iya' ||
            $normalizedQuery === 'mau' ||
            $normalizedQuery === 'ya' ||
            $normalizedQuery === 'bisa'
        );

        $resolved = [
            'specialty' => $entities['specialty'] ?: ($isContextReference ? $sessionContext['last_specialty'] : null),
            'day'       => $entities['day'] ?: ($isContextReference ? $sessionContext['last_day'] : null),
            'service'   => $entities['service'] ?: ($isContextReference ? $sessionContext['last_service'] : null),
            'doctor'    => $entities['doctor'] ?: null,
            'is_followup' => $isContextReference,
        ];

        return $resolved;
    }

    /**
     * Simpan Konteks Percakapan ke Session
     */
    protected function saveContext(array $context): void
    {
        Session::put('fikri_chat_context', [
            'last_intent'    => $context['last_intent'] ?? null,
            'last_specialty' => $context['specialty'] ?? null,
            'last_service'   => $context['service'] ?? null,
            'last_doctor_id' => isset($context['doctor']) ? $context['doctor']->id : null,
            'last_day'       => $context['day'] ?? null,
            'updated_at'     => now(),
        ]);
    }

    /**
     * Reset Sesi Percakapan
     */
    public function resetSession(): void
    {
        Session::forget('fikri_chat_context');
    }

    /**
     * Cek apakah pertanyaan mengarah ke Dokter atau Poliklinik atau Jadwal Praktik
     */
    protected function isDoctorQuery(string $normalizedQuery, array $tokens, array $context): bool
    {
        // Pengecualian: Pertanyaan umum rawat inap / online / IGD tanpa menyebut spesialisasi/dokter
        if (str_contains($normalizedQuery, 'cara daftar rawat inap') || (str_contains($normalizedQuery, 'rawat inap') && empty($context['specialty']))) {
            return false;
        }
        if (str_contains($normalizedQuery, 'cara ke igd') || (str_contains($normalizedQuery, 'igd') && empty($context['specialty']) && !str_contains($normalizedQuery, 'dokter'))) {
            return false;
        }
        if (str_contains($normalizedQuery, 'bpjs') && empty($context['specialty']) && !str_contains($normalizedQuery, 'dokter') && !str_contains($normalizedQuery, 'jadwal')) {
            return false;
        }

        // Jika user menyebut spesialisasi (misal: "poli anak", "saya mau ke poli anak", "dokter bedah", "ada dokter mata?")
        if (!empty($context['specialty'])) {
            return true;
        }

        $doctorKeywords = ['dokter', 'jadwal', 'spesialis', 'praktik', 'praktek', 'dr', 'buka praktek', 'jam praktek', 'poli', 'poliklinik'];
        foreach ($doctorKeywords as $dk) {
            if (str_contains($normalizedQuery, $dk)) {
                return true;
            }
        }

        // Jika user bertanya jadwal lanjutan dari konteks
        if (!empty($context['is_followup']) && !empty($context['specialty'])) {
            return true;
        }

        return false;
    }

    /**
     * Query Live Database untuk Dokter & Jadwal Praktik (Kontekstual & Akurat)
     */
    protected function queryLiveDoctorDatabase(array $context, string $rawQuery): ?array
    {
        $specialty = $context['specialty'];
        $dayFilter = $context['day'];
        $doctorObj = $context['doctor'];

        $allActiveDoctors = Doctor::with(['polyclinic', 'schedules'])->where('is_active', true)->get();
        $filteredDoctors = $allActiveDoctors;

        if ($doctorObj) {
            $filteredDoctors = $filteredDoctors->where('id', $doctorObj->id);
        } elseif ($specialty) {
            $filteredDoctors = $filteredDoctors->filter(function($doc) use ($specialty) {
                $docName = strtolower($doc->name);
                $docDegree = strtolower($doc->title_degree ?? '');
                $specJson = is_array($doc->specialty) ? json_encode($doc->specialty) : strtolower($doc->specialty ?? '');
                $poliJson = $doc->polyclinic ? (is_array($doc->polyclinic->name) ? json_encode($doc->polyclinic->name) : strtolower($doc->polyclinic->name ?? '')) : '';
                $poliSlug = $doc->polyclinic ? strtolower($doc->polyclinic->slug ?? '') : '';

                return str_contains(strtolower($specJson), $specialty) ||
                       str_contains(strtolower($poliJson), $specialty) ||
                       str_contains($poliSlug, $specialty) ||
                       str_contains($docDegree, $specialty);
            });
        }

        // Simpan context untuk percakapan berikutnya
        $this->saveContext($context);

        // KASUS 1: Tidak ada data dokter spesifik di database
        if ($filteredDoctors->isEmpty()) {
            if ($specialty) {
                $specKb = KnowledgeBase::where('is_active', true)
                    ->where(function($q) use ($specialty) {
                        $q->where('intent', $specialty)
                          ->orWhere('intent', "spesialis_{$specialty}")
                          ->orWhere('intent', "doctor_{$specialty}")
                          ->orWhere('intent', "poli_{$specialty}");
                    })->first();

                if ($specKb) {
                    return [
                        'found'       => true,
                        'intent'      => 'doctor_schedule',
                        'score'       => 95.0,
                        'answer'      => $this->enrichAnswerWithHospitalData($specKb->answer, $specKb->intent),
                        'is_fallback' => false,
                        'buttons'     => $this->getIntentActionButtons($specKb->intent),
                        'suggestions' => $this->getIntentSuggestedFollowups($specKb->intent),
                    ];
                }

                $specLabel = ucwords($specialty);
                return [
                    'found'       => true,
                    'intent'      => 'doctor_schedule',
                    'score'       => 90.0,
                    'answer'      => "RSU Fikri Medika Karawang menyediakan pelayanan <strong>Spesialis {$specLabel}</strong>.<br><br>Untuk konfirmasi jadwal praktik terkini atau pendaftaran antrean dokter, Anda dapat melihat menu <a href='/jadwal-dokter' class='text-[#0e7c47] font-bold underline'>Jadwal Dokter</a> atau menghubungi WhatsApp Customer Service kami di <strong>0822-8074-9999</strong>.",
                    'is_fallback' => false,
                    'buttons'     => [
                        ['label' => '📅 Seluruh Jadwal Dokter', 'url' => '/jadwal-dokter'],
                        ['label' => '📝 Buat Janji Online', 'url' => '/buat-janji'],
                    ],
                    'suggestions' => [],
                ];
            }
            return null;
        }

        // KASUS 2: Ada dokter yang ditemukan
        $specLabel = ucwords($specialty ?: 'Spesialis');

        // Cek jika user menanyakan hari spesifik (misal: "hari ini" / "Senin" / "Rabu")
        if ($dayFilter) {
            $doctorsToday = $filteredDoctors->filter(function($doc) use ($dayFilter) {
                return $doc->schedules->contains(function($s) use ($dayFilter) {
                    return stripos($s->day, $dayFilter) !== false;
                });
            });

            if ($doctorsToday->isNotEmpty()) {
                // Dokter ada yang berpraktik pada hari tersebut
                $docHtml = "<div class='space-y-2 pt-1'>";
                foreach ($doctorsToday as $doc) {
                    $specName = $doc->polyclinic ? (is_array($doc->polyclinic->name) ? ($doc->polyclinic->name['id'] ?? '') : $doc->polyclinic->name) : (is_array($doc->specialty) ? ($doc->specialty['id'] ?? '') : $doc->specialty);
                    $docHtml .= "<div class='p-2.5 rounded-xl bg-white border border-emerald-100 shadow-2xs space-y-1'>";
                    $docHtml .= "<div class='font-black text-slate-900 text-xs sm:text-[13px] flex items-center gap-1.5'><span class='w-2 h-2 rounded-full bg-emerald-500'></span>{$doc->name}</div>";
                    $docHtml .= "<div class='text-[11px] text-emerald-800 font-bold'>{$specName} ({$doc->title_degree})</div>";

                    $daySchedules = $doc->schedules->filter(fn($s) => stripos($s->day, $dayFilter) !== false);
                    $docHtml .= "<div class='text-[11px] text-slate-700 font-medium pt-1 border-t border-slate-100'>";
                    foreach ($daySchedules as $sched) {
                        $start = substr($sched->start_time, 0, 5);
                        $end = substr($sched->end_time, 0, 5);
                        $docHtml .= "<div>🕒 <strong>{$sched->day}:</strong> {$start} - {$end} WIB</div>";
                    }
                    $docHtml .= "</div>";
                    $docHtml .= "<div class='pt-1'><a href='/buat-janji?dokter_id={$doc->id}' class='text-[10px] font-bold text-[#0e7c47] underline'>👉 Daftar / Buat Janji Online</a></div>";
                    $docHtml .= "</div>";
                }
                $docHtml .= "</div>";

                $finalAnswer = "✅ <strong>Jadwal Dokter Spesialis {$specLabel} pada hari {$dayFilter}:</strong><br>{$docHtml}";

                return [
                    'found'       => true,
                    'intent'      => 'doctor_schedule',
                    'score'       => 98.0,
                    'answer'      => $finalAnswer,
                    'is_fallback' => false,
                    'buttons'     => [],
                    'suggestions' => [],
                ];
            } else {
                // Dokter TIDAK berpraktik pada hari tersebut, tampilkan jadwal hari lain yang tersedia!
                $allSchedHtml = "<div class='space-y-2 pt-1'>";
                foreach ($filteredDoctors as $doc) {
                    $specName = $doc->polyclinic ? (is_array($doc->polyclinic->name) ? ($doc->polyclinic->name['id'] ?? '') : $doc->polyclinic->name) : (is_array($doc->specialty) ? ($doc->specialty['id'] ?? '') : $doc->specialty);
                    $allSchedHtml .= "<div class='p-2.5 rounded-xl bg-white border border-emerald-100 shadow-2xs space-y-1'>";
                    $allSchedHtml .= "<div class='font-black text-slate-900 text-xs sm:text-[13px] flex items-center gap-1.5'><span class='w-2 h-2 rounded-full bg-emerald-500'></span>{$doc->name}</div>";
                    $allSchedHtml .= "<div class='text-[11px] text-emerald-800 font-bold'>{$specName} ({$doc->title_degree})</div>";

                    if ($doc->schedules->isNotEmpty()) {
                        $allSchedHtml .= "<div class='text-[11px] text-slate-700 font-medium pt-1 border-t border-slate-100 space-y-0.5'>";
                        $allSchedHtml .= "<div class='font-bold text-slate-600 text-[10px] uppercase'>Jadwal Praktik Tersedia:</div>";
                        foreach ($doc->schedules as $sched) {
                            $start = substr($sched->start_time, 0, 5);
                            $end = substr($sched->end_time, 0, 5);
                            $allSchedHtml .= "<div>• <strong>{$sched->day}:</strong> {$start} - {$end} WIB</div>";
                        }
                        $allSchedHtml .= "</div>";
                    }
                    $allSchedHtml .= "<div class='pt-1'><a href='/buat-janji?dokter_id={$doc->id}' class='text-[10px] font-bold text-[#0e7c47] underline'>👉 Daftar / Buat Janji Online</a></div>";
                    $allSchedHtml .= "</div>";
                }
                $allSchedHtml .= "</div>";

                $finalAnswer = "Untuk <strong>hari {$dayFilter}</strong>, dokter spesialis {$specLabel} sedang <strong>tidak ada jadwal praktik</strong>.<br><br>Berikut jadwal hari lain yang tersedia di RSU Fikri Medika:<br>{$allSchedHtml}";

                return [
                    'found'       => true,
                    'intent'      => 'doctor_schedule',
                    'score'       => 98.0,
                    'answer'      => $finalAnswer,
                    'is_fallback' => false,
                    'buttons'     => [],
                    'suggestions' => [],
                ];
            }
        }

        // KASUS 3: Pertanyaan umum poliklinik / dokter (misal: "saya mau ke poli anak")
        $docDetailsHtml = "<div class='space-y-2 pt-1'>";

        foreach ($filteredDoctors as $doc) {
            $specName = $doc->polyclinic ? (is_array($doc->polyclinic->name) ? ($doc->polyclinic->name['id'] ?? '') : $doc->polyclinic->name) : (is_array($doc->specialty) ? ($doc->specialty['id'] ?? '') : $doc->specialty);
            
            $docDetailsHtml .= "<div class='p-2.5 rounded-xl bg-white border border-emerald-100 shadow-2xs space-y-1'>";
            $docDetailsHtml .= "<div class='font-black text-slate-900 text-xs sm:text-[13px] flex items-center gap-1.5'><span class='w-2 h-2 rounded-full bg-emerald-500'></span>{$doc->name}</div>";
            $docDetailsHtml .= "<div class='text-[11px] text-emerald-800 font-bold'>{$specName} ({$doc->title_degree})</div>";

            if ($doc->schedules->isNotEmpty()) {
                $docDetailsHtml .= "<div class='text-[11px] text-slate-700 font-medium pt-1 border-t border-slate-100 space-y-0.5'>";
                $docDetailsHtml .= "<div class='font-bold text-slate-600 text-[10px] uppercase'>Jadwal Praktik:</div>";
                foreach ($doc->schedules as $sched) {
                    $start = substr($sched->start_time, 0, 5);
                    $end = substr($sched->end_time, 0, 5);
                    $docDetailsHtml .= "<div>• <strong>{$sched->day}:</strong> {$start} - {$end} WIB</div>";
                }
                $docDetailsHtml .= "</div>";
            }

            $docDetailsHtml .= "<div class='pt-1'><a href='/buat-janji?dokter_id={$doc->id}' class='text-[10px] font-bold text-[#0e7c47] underline'>👉 Daftar / Buat Janji Online</a></div>";
            $docDetailsHtml .= "</div>";
        }

        $docDetailsHtml .= "</div>";

        $finalAnswer = "Untuk pelayanan <strong>Poli {$specLabel}</strong> di RSU Fikri Medika Karawang, berikut dokter spesialis dan jadwal praktiknya:<br>{$docDetailsHtml}<br><span class='text-[11px] text-slate-500'>Pendaftaran dapat dilakukan langsung di loket admisi atau via menu <a href='/buat-janji' class='text-[#0e7c47] font-bold underline'>Buat Janji Online</a>.</span>";

        return [
            'found'       => true,
            'intent'      => 'doctor_schedule',
            'score'       => 98.0,
            'answer'      => $finalAnswer,
            'is_fallback' => false,
            'buttons'     => [],
            'suggestions' => [],
        ];
    }

    /**
     * Hitung Skor Pencocokan Berbobot (Weighted Keyword Scoring + Fuzzy Typo Match)
     */
    protected function calculateWeightedScore(string $normalizedQuery, array $tokens, KnowledgeBase $kb): float
    {
        if (empty($tokens)) return 0.0;

        $kbQuestionNorm = $this->normalizeText($kb->question);
        $kbKeywordsNorm = $this->normalizeText(($kb->keywords ?? '') . ' ' . ($kb->synonyms ?? ''));
        $targetTextCombined = $kbQuestionNorm . ' ' . $kbKeywordsNorm;
        $kbTokens = $this->tokenizeAndExpand($targetTextCombined);

        if (empty($kbTokens)) return 0.0;

        $score = 0.0;

        // 1. EXACT PHRASE MATCH (+35)
        if (str_contains($targetTextCombined, $normalizedQuery) || str_contains($kbQuestionNorm, $normalizedQuery)) {
            $score += 35.0;
        }

        // 2. TOKEN MATCHING & WEIGHT (+12 per token overlap)
        $matchedTokenCount = 0;
        foreach ($tokens as $token) {
            if (in_array($token, $kbTokens) || str_contains($targetTextCombined, $token)) {
                $matchedTokenCount++;
                $score += 15.0;
            } else {
                // 3. FUZZY & TYPO MATCH (Levenshtein Distance <= 2 untuk token panjang > 3)
                if (strlen($token) >= 4) {
                    foreach ($kbTokens as $kbToken) {
                        if (strlen($kbToken) >= 4 && levenshtein($token, $kbToken) <= 2) {
                            $matchedTokenCount++;
                            $score += 9.0;
                            break;
                        }
                    }
                }
            }
        }

        // 4. OVERLAP RATIO BONUS (+25 max)
        $overlapRatio = $matchedTokenCount / max(1, count($tokens));
        $score += ($overlapRatio * 25.0);

        // 5. JACCARD COEFFICIENT BONUS (+15 max)
        $intersection = array_intersect($tokens, $kbTokens);
        $union = array_unique(array_merge($tokens, $kbTokens));
        $jaccard = count($union) > 0 ? (count($intersection) / count($union)) : 0;
        $score += ($jaccard * 15.0);

        // 6. PRIORITY BIAS (+5 max)
        if ($kb->priority > 0) {
            $score += min(5.0, $kb->priority * 0.2);
        }

        return min(100.0, $score);
    }

    /**
     * Deteksi Pertanyaan Konsultasi Gejala Medis Mandiri (Medical Guardrail)
     */
    protected function isMedicalConsultationQuery(array $tokens, string $normalizedQuery): bool
    {
        $medicalKeywords = [
            'kenapa sakit', 'kenapa dada saya', 'kenapa perut saya', 'resep obat', 
            'obat batuk', 'obat flu', 'obat sakit', 'dosis obat', 'sakit dada', 
            'nyeri dada parah', 'saya sakit apa', 'minta resep', 'aturan minum obat'
        ];

        foreach ($medicalKeywords as $kw) {
            if (str_contains($normalizedQuery, $kw)) {
                return true;
            }
        }

        $symptoms = ['sakit', 'nyeri', 'mual', 'muntah', 'demam', 'pusing', 'batuk', 'sesak', 'diare', 'pingsan', 'berdarah'];
        $count = 0;
        foreach ($symptoms as $sym) {
            if (in_array($sym, $tokens) || str_contains($normalizedQuery, $sym)) {
                $count++;
            }
        }

        return $count >= 3 || (in_array('obat', $tokens) && in_array('sakit', $tokens));
    }

    /**
     * Membangun Respons Khusus Guardrail Keamanan Medis
     */
    protected function buildMedicalSafetyResponse(): array
    {
        return [
            'found'       => true,
            'intent'      => 'medical_disclaimer',
            'score'       => 100.0,
            'answer'      => '⚠️ <strong>Pemberitahuan Medis:</strong><br><br>Saya adalah <strong>Kakak Fikri</strong> (Asisten Virtual RSU Fikri Medika) dan <strong>tidak dapat memberikan diagnosis medis maupun resep obat mandiri</strong> melalui chat.<br><br>Jika Anda atau keluarga sedang mengalami keluhan sakit atau gejala yang mengganggu:<br>• 🚨 <strong>Kondisi Gawat Darurat (Nyeri dada, sesak, trauma berat):</strong> Segera datang ke <strong>IGD 24 Jam RSU Fikri Medika</strong> atau hubungi Call Center <strong>(0267) 8454999</strong>.<br>• 🩺 <strong>Kondisi Non-Darurat:</strong> Silakan konsultasikan langsung dengan <strong>Dokter Spesialis</strong> kami melalui Poliklinik Rawat Jalan.',
            'is_fallback' => false,
            'buttons'     => [
                ['label' => '🚨 Emergency Call IGD (0267 8454999)', 'url' => 'tel:02678454999'],
                ['label' => '📅 Buat Janji Dokter Spesialis', 'url' => '/buat-janji'],
                ['label' => '💬 Chat Customer Care', 'url' => 'https://wa.me/6282280749999?text=' . urlencode("Halo RSU Fikri Medika, saya ingin konsultasi pendaftaran poliklinik")],
            ],
            'suggestions' => [
                ['label' => '📅 Jadwal Dokter Spesialis', 'query' => 'Jadwal dokter spesialis'],
                ['label' => '🚨 Informasi Layanan IGD 24 Jam', 'query' => 'Layanan IGD 24 Jam'],
                ['label' => '📋 Syarat Berobat BPJS', 'query' => 'Syarat BPJS Kesehatan'],
            ],
        ];
    }

    /**
     * Perkaya Respons Jawaban Statis dengan Data Dinamis Rumah Sakit
     */
    protected function enrichAnswerWithHospitalData(string $answer, string $intent): string
    {
        $profile = HospitalProfile::first();
        if ($profile) {
            $phone = $profile->phone ?? '(0267) 8615555';
            $emergency = $profile->emergency_call ?? '(0267) 8454999';
            $wa = $profile->whatsapp ?? '0822-8074-9999';
            $address = $profile->address ?? 'Jl. Raya Kosambi - Telagasari No. 1, Klari, Karawang';

            $answer = str_replace(
                ['(0267) 8454999', '0822-8074-9999', 'info@rsufikrimedika.com'],
                [$emergency, $wa, $profile->email ?? 'info@rsufikrimedika.com'],
                $answer
            );
        }

        return $answer;
    }

    /**
     * Ambil Tombol Aksi Relevan Sesuai Intent
     */
    protected function getIntentActionButtons(string $intent): array
    {
        $map = [
            'greeting' => [
                ['label' => '👨‍⚕️ Cari Dokter', 'query' => 'Cari Dokter Spesialis'],
                ['label' => '📅 Jadwal Dokter', 'url' => '/jadwal-dokter'],
                ['label' => '📋 Pendaftaran BPJS', 'query' => 'Syarat BPJS Kesehatan'],
                ['label' => '🚨 Emergency IGD', 'query' => 'Nomor IGD 24 Jam'],
            ],
            'hospital_hours' => [
                ['label' => '📅 Cek Jadwal Dokter', 'url' => '/jadwal-dokter'],
                ['label' => '🚨 Emergency IGD 24 Jam', 'url' => 'tel:02678454999'],
                ['label' => '💬 Chat WhatsApp', 'url' => 'https://wa.me/6282280749999'],
            ],
            'hospital_location' => [
                ['label' => '📍 Buka Google Maps', 'url' => 'https://maps.google.com/?q=RSU+Fikri+Medika+Karawang'],
                ['label' => '📞 Telepon RS', 'url' => 'tel:02678615555'],
            ],
            'hospital_contact' => [
                ['label' => '💬 WhatsApp Info 0822-8074-9999', 'url' => 'https://wa.me/6282280749999'],
                ['label' => '📞 Telepon (0267) 8615555', 'url' => 'tel:02678615555'],
                ['label' => '🚨 Emergency (0267) 8454999', 'url' => 'tel:02678454999'],
            ],
            'emergency' => [
                ['label' => '🚨 Telepon IGD (0267 8454999)', 'url' => 'tel:02678454999'],
                ['label' => '🚑 Panggil Ambulans WhatsApp', 'url' => 'https://wa.me/6282280749999?text=' . urlencode("DARURAT: Butuh ambulans penjemputan segera")],
            ],
            'registration_bpjs' => [
                ['label' => '📝 Buat Janji Online', 'url' => '/buat-janji'],
                ['label' => '📅 Cek Jadwal Dokter', 'url' => '/jadwal-dokter'],
                ['label' => '💬 Konfirmasi Berkas BPJS via WA', 'url' => 'https://wa.me/6282280749999?text=' . urlencode("Halo, saya mau tanya berkas rujukan BPJS")],
            ],
            'registration_online' => [
                ['label' => '🌐 Buka Form Buat Janji Online', 'url' => '/buat-janji'],
                ['label' => '💬 Daftar via WhatsApp', 'url' => 'https://wa.me/6282280749999?text=' . urlencode("Halo RSU Fikri Medika, saya mau daftar berobat")],
            ],
            'inpatient' => [
                ['label' => '🛏️ Informasi Kamar VIP & Kelas', 'url' => '/layanan/rawat-inap'],
                ['label' => '💬 Info Ketersediaan Bed Kamar', 'url' => 'https://wa.me/6282280749999?text=' . urlencode("Halo, saya ingin tanya ketersediaan kamar rawat inap")],
            ],
            'mcu' => [
                ['label' => '🩺 Konsultasi Paket MCU', 'url' => 'https://wa.me/6282280749999?text=' . urlencode("Halo, saya ingin menanyakan paket Medical Check Up (MCU)")],
                ['label' => '🏥 Detail Layanan MCU', 'url' => '/layanan/medical-check-up'],
            ],
            'spesialis_mata' => [
                ['label' => '👁️ Jadwal Dokter Spesialis Mata', 'query' => 'Dokter spesialis mata'],
                ['label' => '📝 Buat Janji Spesialis Mata', 'url' => '/buat-janji?poli=mata'],
            ],
            'kemilau_cinta' => [
                ['label' => '👶 Halaman Kemilau Cinta', 'url' => '/layanan/kemilau-cinta-layanan-ibu-anak'],
                ['label' => '🤰 Jadwal Dokter Kandungan (Sp.OG)', 'query' => 'Dokter kandungan'],
            ],
        ];

        return $map[$intent] ?? [
            ['label' => '📅 Jadwal Dokter', 'url' => '/jadwal-dokter'],
            ['label' => '📝 Buat Janji Online', 'url' => '/buat-janji'],
            ['label' => '💬 WhatsApp CS', 'url' => 'https://wa.me/6282280749999'],
        ];
    }

    /**
     * Ambil Saran Pertanyaan Lanjutan (Suggested Follow-up Questions)
     */
    protected function getIntentSuggestedFollowups(string $intent): array
    {
        $map = [
            'greeting' => [
                ['label' => '👁️ Ada dokter mata?', 'query' => 'Ada dokter mata?'],
                ['label' => '🕒 Jam buka rumah sakit?', 'query' => 'Jam buka rumah sakit?'],
                ['label' => '📋 Cara daftar online?', 'query' => 'Bagaimana cara daftar online?'],
                ['label' => '💳 Bisa berobat pakai BPJS?', 'query' => 'Apakah menerima pasien BPJS?'],
            ],
            'hospital_hours' => [
                ['label' => '👨‍⚕️ Jadwal dokter hari ini?', 'query' => 'Jadwal dokter hari ini'],
                ['label' => '🚨 Layanan IGD 24 Jam', 'query' => 'Layanan IGD 24 jam'],
                ['label' => '📍 Lokasi RSU Fikri Medika', 'query' => 'Lokasi RS di mana?'],
            ],
            'registration_bpjs' => [
                ['label' => '📝 Cara daftar online', 'query' => 'Bagaimana cara daftar online?'],
                ['label' => '👨‍⚕️ Jadwal Dokter Spesialis', 'query' => 'Jadwal dokter spesialis'],
                ['label' => '🛏️ Kamar rawat inap BPJS', 'query' => 'Fasilitas rawat inap BPJS'],
            ],
            'doctor_schedule' => [
                ['label' => '📝 Buat janji berobat', 'query' => 'Saya mau buat janji dokter'],
                ['label' => '📋 Syarat pendaftaran rawat jalan', 'query' => 'Syarat daftar rawat jalan'],
                ['label' => '👶 Dokter Spesialis Anak', 'query' => 'Dokter spesialis anak'],
            ],
            'mcu' => [
                ['label' => '💰 Berapa biaya paket MCU?', 'query' => 'Berapa harga MCU?'],
                ['label' => '💍 MCU Pra Nikah', 'query' => 'Paket MCU pra nikah'],
                ['label' => '🧪 Tes Laboratorium', 'query' => 'Layanan laboratorium 24 jam'],
            ],
        ];

        return $map[$intent] ?? [
            ['label' => '👨‍⚕️ Cari Dokter', 'query' => 'Cari Dokter Spesialis'],
            ['label' => '🏥 Layanan Unggulan', 'query' => 'Apa saja layanan unggulan?'],
            ['label' => '📋 Cara Daftar Online', 'query' => 'Bagaimana cara daftar online?'],
            ['label' => '📞 Nomor Telepon RS', 'query' => 'Nomor telepon rumah sakit'],
        ];
    }

    /**
     * Membangun Respons Fallback Alami dan Informatif
     */
    public function buildFallbackResponse(string $rawQuery, ?string $sessionId = null): array
    {
        return [
            'found'       => false,
            'intent'      => 'fallback_unknown',
            'score'       => 0.0,
            'answer'      => 'Maaf, Kakak Fikri belum menemukan informasi yang persis dengan pertanyaan Anda 😊<br><br>Saya bisa membantu Anda mencari informasi seputar:<br>• 👨‍⚕️ <strong>Dokter & Jadwal Praktik</strong><br>• 🏥 <strong>Layanan Rumah Sakit & Unggulan</strong><br>• 📋 <strong>Pendaftaran Rawat Jalan & Online</strong><br>• 💳 <strong>Persyaratan Pasien BPJS Kesehatan</strong><br>• 🩺 <strong>Paket Medical Check Up (MCU)</strong><br>• 🛏️ <strong>Kamar Rawat Inap (VIP/Kelas)</strong><br>• 📍 <strong>Lokasi & Kontak Rumah Sakit</strong><br><br>Silakan pilih salah satu topik di bawah atau tanyakan langsung pada Customer Service kami:',
            'is_fallback' => true,
            'buttons'     => [
                ['label' => '💬 Chat WhatsApp CS (0822-8074-9999)', 'url' => 'https://wa.me/6282280749999?text=' . urlencode("Halo RSU Fikri Medika, saya ingin tanya informasi: " . $rawQuery)],
                ['label' => '📞 Telepon RS (0267 8615555)', 'url' => 'tel:02678615555'],
            ],
            'suggestions' => [
                ['label' => '👨‍⚕️ Jadwal Dokter Spesialis', 'query' => 'Jadwal dokter spesialis'],
                ['label' => '🕒 Jam Buka Rumah Sakit', 'query' => 'Jam buka rumah sakit?'],
                ['label' => '📋 Cara Daftar BPJS', 'query' => 'Persyaratan BPJS Kesehatan'],
                ['label' => '🌟 Layanan Unggulan', 'query' => 'Apa saja layanan unggulan?'],
                ['label' => '🩺 Paket MCU', 'query' => 'Layanan MCU'],
                ['label' => '📍 Lokasi & Alamat RS', 'query' => 'Lokasi RS di mana?'],
            ],
        ];
    }

    /**
     * Rekam Pertanyaan yang Belum Dikenali (Continuous Learning System)
     */
    protected function logUnrecognizedQuery(string $rawQuery, string $normalizedQuery, ?string $sessionId, float $confidence, string $intent): void
    {
        try {
            if (strlen(trim($rawQuery)) >= 3) {
                ChatbotUnrecognizedQuery::create([
                    'session_id'       => $sessionId,
                    'raw_query'        => $rawQuery,
                    'normalized_query' => $normalizedQuery,
                    'detected_intent'  => $intent,
                    'confidence_score' => $confidence,
                    'is_resolved'      => false,
                ]);
            }
        } catch (\Exception $e) {
            // Silently handle logging exception so chat response is never blocked
        }
    }

    protected function getTodayDayName(): string
    {
        $dayNum = date('N'); // 1 = Monday, 7 = Sunday
        $map = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu',
        ];
        return $map[$dayNum] ?? 'Senin';
    }

    protected function getTomorrowDayName(): string
    {
        $dayNum = (date('N') % 7) + 1;
        $map = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu',
        ];
        return $map[$dayNum] ?? 'Selasa';
    }
}
