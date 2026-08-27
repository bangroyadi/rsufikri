<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KnowledgeBase;
use App\Models\Career;
use App\Models\HospitalEvent;
use App\Models\Service;
use App\Models\HospitalProfile;
use App\Models\Promo;
use App\Models\Polyclinic;

class HospitalKnowledgeBaseGeneratorSeeder extends Seeder
{
    public function run(): void
    {
        $profile = HospitalProfile::first();
        $openCareers = Career::where('is_active', true)->where('status', 'dibuka')->get();
        $events = HospitalEvent::where('is_active', true)->orderBy('event_date', 'desc')->take(5)->get();
        $services = Service::where('is_active', true)->get();

        $kbItems = [];

        // ══════════════════════════════════════════════════════════
        // 1. KARIR & REKRUTMEN KNOWLEDGE
        // ══════════════════════════════════════════════════════════
        $careerListText = "";
        if ($openCareers->isNotEmpty()) {
            foreach ($openCareers as $c) {
                $deadline = $c->deadline ? \Carbon\Carbon::parse($c->deadline)->translatedFormat('d F Y') : 'Terbuka';
                $careerListText .= "• 💼 <strong>" . htmlspecialchars($c->tr('title')) . "</strong> (" . htmlspecialchars($c->tr('department')) . ") - Batas: " . $deadline . "<br>";
            }
        } else {
            $careerListText = "<em>Saat ini belum ada posisi baru yang dibuka. Namun Anda dapat memeriksa secara berkala di halaman Karir kami.</em><br>";
        }

        $kbItems[] = [
            'category'  => 'Karir & Rekrutmen',
            'intent'    => 'career_vacancies',
            'question'  => 'Informasi Lowongan Kerja & Karir di RSU Fikri Medika',
            'keywords'  => 'karir, lowongan, loker, lowongan kerja, info loker, rekrutmen, hrd, lamaran, melamar, buka loker, posisi kerja, perawat, dokter, nakes, analis, apoteker, administrasi, bidan, radiografer, ada lowongan kerja apa, ada loker apa saja',
            'synonyms'  => 'ada lowongan kerja apa aja, apakah ada lowongan kerja, info karir rs fikri, loker rs fikri medika terbaru, mau melamar kerja, lowongan perawat, lowongan dokter umum, info lowongan kerja terbaru, ada loker apa, lowongan yang dibuka',
            'answer'    => '💼 <strong>Peluang Karir di RSU Fikri Medika Karawang:</strong><br><br>Bergabunglah bersama keluarga besar RSU Fikri Medika untuk bersama-sama melayani masyarakat dengan profesional dan Islami.<br><br><strong>Posisi Lowongan yang Tersedia:</strong><br>' . $careerListText . '<br>📄 <strong>Cara Melamar:</strong><br>Silakan kunjungi menu <a href="' . url('/karir') . '" class="text-[#0e7c47] font-bold underline">Karir RSU Fikri Medika</a>, pilih posisi yang diminati, dan unggah berkas CV (PDF maks. 15MB) secara online!',
            'priority'  => 95,
            'is_active' => true,
        ];

        $kbItems[] = [
            'category'  => 'Karir & Rekrutmen',
            'intent'    => 'career_apply_process',
            'question'  => 'Cara & Syarat Melamar Pekerjaan di RSU Fikri Medika',
            'keywords'  => 'cara melamar, syarat melamar, kirim cv, format cv, berkas lamaran, str, upload lamaran, cara apply, batas lamaran, kontak hrd',
            'synonyms'  => 'bagaimana cara melamar kerja, format berkas lamaran, kirim cv kemana, syarat daftar perawat, cara melamar kerja di rs fikri',
            'answer'    => '📝 <strong>Petunjuk Pendaftaran & Melamar Kerja di RSU Fikri Medika:</strong><br><br>1. Buka halaman <a href="' . url('/karir') . '" class="text-[#0e7c47] font-bold underline">Halaman Karir</a>.<br>2. Klik tombol <strong>Lihat Detail & Lamar</strong> pada posisi yang Anda tuju.<br>3. Isi formulir nama, email, nomor WhatsApp, pendidikan terakhir, dan pengalaman.<br>4. Unggah berkas <strong>Curriculum Vitae (CV) & Ijazah/STR</strong> dalam format <strong>PDF</strong> (maksimal 15 MB).<br>5. Klik <strong>Kirim Lamaran Sekarang</strong>.<br><br>💡 <em>Kandidat yang memenuhi kualifikasi akan dihubungi langsung oleh Tim HRD via WhatsApp / Email resmi.</em>',
            'priority'  => 90,
            'is_active' => true,
        ];

        // ══════════════════════════════════════════════════════════
        // 2. EVENT & KEGIATAN RUMAH SAKIT
        // ══════════════════════════════════════════════════════════
        $eventListText = "";
        if ($events->isNotEmpty()) {
            foreach ($events as $ev) {
                $evDate = $ev->event_date ? \Carbon\Carbon::parse($ev->event_date)->translatedFormat('d F Y') : '';
                $eventListText .= "• 📌 <strong>" . htmlspecialchars($ev->tr('title')) . "</strong> (" . $evDate . ")<br>";
            }
        } else {
            $eventListText = "<em>Dokumentasi dan liputan kegiatan rumah sakit dapat dilihat di menu Informasi Event.</em><br>";
        }

        $kbItems[] = [
            'category'  => 'Event & Informasi',
            'intent'    => 'hospital_events',
            'question'  => 'Informasi Event, Seminar Kesehatan & Kegiatan RS',
            'keywords'  => 'event, acara, kegiatan, seminar, webinar, donor darah, bakti sosial, baksos, khitanan, penyuluhan, liputan, press release, dokumentasi acara, event terbaru, kegiatan rs, acara terbaru, ada event apa saja',
            'synonyms'  => 'ada event apa saja, ada acara apa di rs fikri, info seminar kesehatan, kegiatan bakti sosial fikri medika, jadwal donor darah, kegiatan terbaru, event terbaru, event apa saja yang terbaru, ada event apa saja yang terbaru, ada kegiatan apa saja',
            'answer'    => '🎉 <strong>Agenda & Dokumentasi Kegiatan RSU Fikri Medika:</strong><br><br>RSU Fikri Medika rutin menyelenggarakan berbagai seminar kesehatan, bakti sosial, edukasi medis komunitas, dan pelayanan bakti masyarakat.<br><br><strong>Kegiatan Terbaru:</strong><br>' . $eventListText . '<br>📸 Anda dapat membaca liputan lengkap dan melihat galeri foto dokumentasi di halaman <a href="' . url('/informasi/event') . '" class="text-[#0e7c47] font-bold underline">Dokumentasi Event RSU Fikri Medika</a>.',
            'priority'  => 90,
            'is_active' => true,
        ];

        // ══════════════════════════════════════════════════════════
        // 3. LAYANAN UNGGULAN & SPESIALISTIK
        // ══════════════════════════════════════════════════════════
        $kbItems[] = [
            'category'  => 'Layanan Unggulan',
            'intent'    => 'service_trauma_center',
            'question'  => 'Layanan Trauma Center (Kecelakaan Kerja BPJS TK & Bedah)',
            'keywords'  => 'trauma center, kecelakaan, tabrakan, bpjs tk, ketenagakerjaan, patah tulang darurat, bedah saraf, ortopedi darurat, cedera kepala, luka parah',
            'synonyms'  => 'apakah ada trauma center, klaim bpjs ketenagakerjaan kecelakaan kerja, penanganan patah tulang darurat',
            'answer'    => '🏥 <strong>Trauma Center 24 Jam RSU Fikri Medika:</strong><br><br>Pusat penanganan komprehensif bagi pasien cedera trauma akibat kecelakaan lalu lintas maupun kecelakaan kerja.<br><br>• 🚑 <strong>Kerjasama BPJS Ketenagakerjaan (BPJS TK):</strong> Menjamin perawatan kecelakaan kerja tanpa biaya tambahan (sesuai ketentuan penjaminan).<br>• 👨‍⚕️ <strong>Tim Spesialis Siaga:</strong> Dokter Spesialis Orthopedi (Tulang), Bedah Saraf, Bedah Umum, dan Anestesi.<br>• 🩻 <strong>Fasilitas:</strong> Kamar Operasi Cito, CT-Scan Digital, dan Ruang Resusitasi Modern.<br><br>🔗 <a href="' . url('/layanan/trauma-center') . '" class="text-[#0e7c47] font-bold underline">Lihat Detail Layanan Trauma Center</a>',
            'priority'  => 90,
            'is_active' => true,
        ];

        $kbItems[] = [
            'category'  => 'Layanan Unggulan',
            'intent'    => 'service_kemilau_cinta',
            'question'  => 'Layanan Kemilau Cinta (Kesehatan Ibu & Anak / ERACS)',
            'keywords'  => 'kemilau cinta, ibu dan anak, melahirkan, persalinan, eracs, caesar, usg 4d, dokter kandungan, dokter anak, imunisasi, nicu, picu, klinik laktasi',
            'synonyms'  => 'program kemilau cinta, paket melahirkan eracs, usg 4 dimensi janin, dokter spesialis kandungan rs fikri',
            'answer'    => '👶 <strong>Layanan Kemilau Cinta (Ibu & Anak):</strong><br><br>Program unggulan terpadu untuk kesehatan ibu hamil, persalinan nyaman, serta tumbuh kembang bayi dan buah hati.<br><br>• 🌸 <strong>Persalinan Minim Nyeri ERACS:</strong> Metode pemulihan pasca operasi caesar yang jauh lebih cepat (2 jam sudah bisa duduk dan mobilisasi).<br>• 🩺 <strong>USG 4D HD-Live:</strong> Pemeriksaan detail visual wajah dan organ janin dalam kandungan.<br>• 🏥 <strong>NICU & PICU:</strong> Ruang perawatan intensif khusus bayi baru lahir dan anak.<br>• 🍼 <strong>Klinik Laktasi & Pijat Bayi Sehat.</strong><br><br>🔗 <a href="' . url('/layanan/kemilau-cinta-layanan-ibu-anak') . '" class="text-[#0e7c47] font-bold underline">Lihat Detail Layanan Kemilau Cinta</a>',
            'priority'  => 90,
            'is_active' => true,
        ];

        $kbItems[] = [
            'category'  => 'Layanan Unggulan',
            'intent'    => 'service_mata',
            'question'  => 'Layanan Spesialis Mata & Operasi Katarak Phacoemulsifikasi',
            'keywords'  => 'mata, katarak, phaco, phacoemulsifikasi, operasi mata, minus, rabun, dokter mata, lasik, retina, glaukoma, mata buram, periksa mata',
            'synonyms'  => 'operasi katarak di rs fikri medika, biaya operasi katarak, operasi katarak tanpa jahit, periksa mata sp.m',
            'answer'    => '👁️ <strong>Layanan Spesialis Mata RSU Fikri Medika:</strong><br><br>Pusat diagnostik dan perawatan kesehatan mata dengan peralatan modern.<br><br>• 🎯 <strong>Operasi Katarak Phacoemulsifikasi:</strong> Operasi katarak modern dengan sayatan mikro tanpa jahitan, waktu tindakan cepat (+- 15 menit), dan pasien dapat langsung pulang pada hari yang sama (One Day Care).<br>• 🔍 <strong>Skrining Glaukoma & Retina:</strong> Pemeriksaan tekanan bola mata dan saraf mata.<br>• 👓 <strong>Pemeriksaan Refraksi & Mata Anak.</strong><br><br>🔗 <a href="' . url('/layanan/layanan-spesialis-mata') . '" class="text-[#0e7c47] font-bold underline">Lihat Detail Layanan Spesialis Mata</a>',
            'priority'  => 85,
            'is_active' => true,
        ];

        $kbItems[] = [
            'category'  => 'Layanan Medis',
            'intent'    => 'service_rawat_inap',
            'question'  => 'Fasilitas Kamar Rawat Inap (VVIP, VIP, Kelas 1, 2, 3 BPJS)',
            'keywords'  => 'rawat inap, kamar inap, kamar rawat, vvip, vip, kelas 1, kelas 2, kelas 3, kamar bpjs, fasilitas kamar, sewa kamar, opname, besuk, jam jenguk',
            'synonyms'  => 'fasilitas kamar rawat inap rsu fikri medika, harga kamar rawat inap, apakah kamar kelas 3 ada ac',
            'answer'    => '🛏️ <strong>Fasilitas Instalasi Rawat Inap RSU Fikri Medika:</strong><br><br>Ruang perawatan dirancang bersih, tenang, dan higienis dengan pemantauan perawat 24 jam.<br><br>• 👑 <strong>Kelas VVIP & VIP:</strong> 1 Pasien per kamar, Smart Bed Electric, AC, TV LED, Kulkas, Sofa Penunggu, Kamar Mandi Dalam.<br>• 🏥 <strong>Kelas 1 & Kelas 2:</strong> 2-3 Bed, AC, TV, Tirai Sekat Medis Kedap, Kamar Mandi Dalam.<br>• 🛡️ <strong>Kelas 3 Standar KRIS BPJS:</strong> Maksimal 4 Bed, AC, Sirkulasi Bertekanan, Dijamin Penuh oleh BPJS Kesehatan.<br><br>🔗 <a href="' . url('/layanan/rawat-inap') . '" class="text-[#0e7c47] font-bold underline">Lihat Informasi Rawat Inap Lengkap</a>',
            'priority'  => 85,
            'is_active' => true,
        ];

        $kbItems[] = [
            'category'  => 'Layanan Medis',
            'intent'    => 'service_rehab_medik',
            'question'  => 'Instalasi Rehabilitasi Medik & Fisioterapi',
            'keywords'  => 'fisioterapi, rehab medik, rehabilitasi medik, terapi fisik, stroke, saraf kejepit, hnp, tens, mwd, traksi, kaku leher, nyeri pinggang, terapi jalan',
            'synonyms'  => 'jadwal fisioterapi, terapi pasca stroke di rs fikri, fisioterapi saraf terjepit, apakah fisioterapi bisa bpjs',
            'answer'    => '🚶‍♂️ <strong>Instalasi Rehabilitasi Medik & Fisioterapi:</strong><br><br>Melayani pemulihan fungsi gerak tubuh, saraf, dan otot dengan fisioterapis berpengalaman.<br><br>• ⚡ <strong>Modalitas Terapi:</strong> TENS (Elektroterapi Nyeri), MWD (Pemanasan Sendi Dalam), Traksi Lumbal/Servikal Mekanik.<br>• 🧠 <strong>Rehabilitasi Pasca Stroke:</strong> Latihan gerak motorik, keseimbangan, dan kemandirian jalan.<br>• 🦴 <strong>Fisioterapi Nyeri & Tulang:</strong> Saraf kejepit (HNP), radang sendi lutut, dan kekakuan sendi pasca operasi.<br><br>🔗 <a href="' . url('/layanan/rehabilitasi-medik') . '" class="text-[#0e7c47] font-bold underline">Lihat Informasi Fisioterapi</a>',
            'priority'  => 85,
            'is_active' => true,
        ];

        $kbItems[] = [
            'category'  => 'Penunjang Medis',
            'intent'    => 'service_radiologi_lab',
            'question'  => 'Instalasi Radiologi & Laboratorium Klinik 24 Jam',
            'keywords'  => 'radiologi, rontgen, x-ray, ct scan, laboratorium, cek darah, tes lab, urine, patologi, asam urat, kolesterol, gula darah, rontgen paru, panoramic gigi',
            'synonyms'  => 'apakah laboratorium buka 24 jam, biaya rontgen thorax, cek darah cito igd, hasil lab berapa lama',
            'answer'    => '🔬 <strong>Layanan Diagnostik & Penunjang Medis 24 Jam:</strong><br><br>• 🩻 <strong>Radiologi Digital:</strong> Rontgen Digital X-Ray (DR), Panoramic Gigi, USG 4D, dan CT-Scan Digital dengan proteksi radiasi aman.<br>• 🧪 <strong>Laboratorium Klinik 24 Jam:</strong> Auto-Analyzer darah lengkap, kimia darah, profil lipid/kolesterol, tes infeksi DBD/Tifoid, fungsi hati/ginjal, dan tes urine.<br>• 🔬 <strong>Laboratorium Patologi Anatomi:</strong> Biopsi jaringan tumor, FNAB jarum halus, dan Pap Smear.<br><br>🔗 <a href="' . url('/layanan/penunjang-medis') . '" class="text-[#0e7c47] font-bold underline">Lihat Penunjang Medis</a>',
            'priority'  => 85,
            'is_active' => true,
        ];

        $kbItems[] = [
            'category'  => 'Penunjang Medis',
            'intent'    => 'service_farmasi_24h',
            'question'  => 'Pelayanan Farmasi & Apotek Rumah Sakit 24 Jam',
            'keywords'  => 'farmasi, apotek, beli obat, tebus resep, obat 24 jam, obat bpjs, obat prb, konseling apoteker, obat sirup, puyer',
            'synonyms'  => 'apakah apotek rs fikri buka 24 jam, tebus resep dokter malam hari, obat kronis bpjs rujuk balik',
            'answer'    => '💊 <strong>Instalasi Farmasi RSU Fikri Medika Buka 24 Jam Non-Stop:</strong><br><br>Melayani kebutuhan obat resep rawat jalan, rawat inap, dan gawat darurat IGD.<br><br>• 🛡️ <strong>100% Obat Asli & Terdaftar BPOM:</strong> Penyimpanan berstandar suhu ruangan dan cold storage rantai dingin.<br>• 📋 <strong>Program Rujuk Balik (PRB) BPJS:</strong> Melayani obat rutin pasien kronis (Diabetes, Hipertensi, Jantung).<br>• 💬 <strong>Pelayanan Informasi Obat (PIO):</strong> Konseling gratis oleh Apoteker mengenai aturan pakai dan interaksi obat.<br><br>🔗 <a href="' . url('/layanan/farmasi-24-jam') . '" class="text-[#0e7c47] font-bold underline">Lihat Informasi Farmasi</a>',
            'priority'  => 85,
            'is_active' => true,
        ];

        // ══════════════════════════════════════════════════════════
        // 4. VISI, MISI, MOTTO & PROFIL
        // ══════════════════════════════════════════════════════════
        $kbItems[] = [
            'category'  => 'Profil RS',
            'intent'    => 'hospital_vision_mission',
            'question'  => 'Visi, Misi & Motto RSU Fikri Medika',
            'keywords'  => 'visi, misi, motto, tujuan, nilai, semboyan, komitmen, prinsip',
            'synonyms'  => 'apa visi misi rs fikri medika, apa motto rumah sakit fikri medika',
            'answer'    => '🌟 <strong>Visi, Misi & Motto RSU Fikri Medika:</strong><br><br>🎯 <strong>Visi:</strong><br>Menjadikan Rumah Sakit Swasta yang menyediakan layanan berkualitas, unggul, dan terpercaya di Karawang.<br><br>🚀 <strong>Misi:</strong><br>1. Memberikan Pelayanan Kesehatan dan Medis terbaik kepada masyarakat.<br>2. Mewujudkan Kesejahteraan bagi seluruh Stakeholder.<br>3. Peduli kepada lingkungan, masyarakat, dan bangsa.<br><br>💚 <strong>Motto:</strong><br><em>"Kesehatan Anda Prioritas Layanan Utama Kami."</em>',
            'priority'  => 90,
            'is_active' => true,
        ];

        // Insert or update all items
        foreach ($kbItems as $item) {
            KnowledgeBase::updateOrCreate(
                ['intent' => $item['intent']],
                $item
            );
        }
    }
}
