<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KnowledgeBase;

class KnowledgeBaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kbData = [
            // PROFIL RS
            [
                'category'  => 'Profil RS',
                'intent'    => 'profil_rs',
                'question'  => 'Tentang RSU Fikri Medika Karawang',
                'keywords'  => 'profil, sejarah, tentang, umum, pt, berdiri, visi, misi, owner, karawang',
                'synonyms'  => 'profil rs, mengenai rumah sakit, sejarah rsu fikri medika, pt karya mandiri medika utama',
                'answer'    => 'RSU Fikri Medika Karawang bernaung di bawah <strong>PT. Karya Mandiri Medika Utama</strong>. Kami berkomitmen memberikan pelayanan kesehatan medis komprehensif, profesional, berteknologi modern, serta mengedepankan nilai-nilai Islami dan keramahan bagi seluruh masyarakat.',
                'priority'  => 10,
                'is_active' => true,
            ],

            // IGD / EMERGENCY
            [
                'category'  => 'Gawat Darurat',
                'intent'    => 'igd',
                'question'  => 'Layanan IGD 24 Jam & Ambulans Siaga',
                'keywords'  => 'igd, gawat, darurat, emergency, ambulans, kecelakaan, pertolongan, telepon, 24 jam',
                'synonyms'  => 'nomor igd, unit gawat darurat, ugd, panggilan darurat, jam buka igd',
                'answer'    => '🚨 <strong>Instalasi Gawat Darurat (IGD 24 Jam) RSU Fikri Medika</strong><br><br>Tim medis & perawat kami siap 24 jam nonstop.<br>• Call Center Emergency: <strong>(0267) 8454999</strong><br>• WhatsApp IGD: <strong>0812-3456-7890</strong><br><br>Layanan ambulans siaga 24 jam juga siap untuk penjemputan pasien darurat.',
                'priority'  => 20,
                'is_active' => true,
            ],

            // BPJS KESEHATAN
            [
                'category'  => 'Asuransi & BPJS',
                'intent'    => 'bpjs',
                'question'  => 'Layanan Pasien BPJS Kesehatan',
                'keywords'  => 'bpjs, kis, rujukan, faskes, syarat, berkas, klaim, jkn, gratis',
                'synonyms'  => 'apakah bisa bpjs, pendaftaran bpjs, persyaratan bpjs kesehatan, faskes tingkat 1',
                'answer'    => 'Ya, RSU Fikri Medika melayani pasien <strong>BPJS Kesehatan</strong>.<br><br>Persyaratan berkas:<br>1. Kartu BPJS Kesehatan / KIS Aktif<br>2. Surat Rujukan dari Faskes Tingkat 1 (Puskesmas/Klinik)<br>3. KTP dan Kartu Keluarga (KK)<br><br>Pastikan rujukan Anda masih berlaku saat mendaftar.',
                'priority'  => 15,
                'is_active' => true,
            ],

            // PENDAFTARAN & RAWAT JALAN
            [
                'category'  => 'Pendaftaran',
                'intent'    => 'pendaftaran',
                'question'  => 'Cara Pendaftaran Pasien Rawat Jalan / Poliklinik',
                'keywords'  => 'daftar, pendaftaran, berobat, registrasi, cara, poli, antrean, poliklinik, rawat jalan',
                'synonyms'  => 'mau berobat, daftar poli, pendaftaran rawat jalan, cara daftar berobat',
                'answer'    => 'Untuk pendaftaran berobat / rawat jalan ke Poliklinik Spesialis:<br><br>1. Datang langsung ke Loket Pendaftaran RSU Fikri Medika.<br>2. Atau cek informasi pendaftaran online melalui menu <a href="/buat-janji" class="font-bold underline text-[#0e7c47]">Buat Janji / Pendaftaran Online</a> di website kami.<br><br>Jangan lupa membawa identitas (KTP/BPJS/Asuransi).',
                'priority'  => 15,
                'is_active' => true,
            ],

            // JADWAL DOKTER & DOKTER SPESIALIS
            [
                'category'  => 'Dokter & Spesialis',
                'intent'    => 'jadwal_dokter',
                'question'  => 'Jadwal Dokter Spesialis & Praktik',
                'keywords'  => 'jadwal, dokter, spesialis, penyakit dalam, anak, kebidanan, og, kandungan, mata, gigi, bedah, jam, praktik, praktek',
                'synonyms'  => 'jadwal praktek dokter, dokter spesialis anak, dokter kandungan, jadwal dokter hari ini',
                'answer'    => 'Untuk melihat daftar lengkap dokter spesialis dan jadwal praktik terupdate, Anda dapat langsung mengunjungi halaman <a href="/jadwal-dokter" class="font-bold underline text-[#0e7c47]">Jadwal Dokter</a> di menu website.<br><br>Kami memiliki dokter spesialis Penyakit Dalam, Kebidanan & Kandungan (Sp.OG), Anak (Sp.A), Bedah (Sp.B), Mata (Sp.M), serta Spesialis Gigi.',
                'priority'  => 15,
                'is_active' => true,
            ],

            // RAWAT INAP
            [
                'category'  => 'Fasilitas & Layanan',
                'intent'    => 'rawat_inap',
                'question'  => 'Fasilitas Rawat Inap & Kamar Pasien',
                'keywords'  => 'rawat inap, opname, kamar, kelas, vvip, vip, fasilitas, bed, inap',
                'synonyms'  => 'fasilitas rawat inap, kamar opname, ruang rawat inap',
                'answer'    => 'RSU Fikri Medika menyediakan fasilitas <strong>Rawat Inap</strong> yang nyaman dari Kelas 3, Kelas 2, Kelas 1, VIP, hingga VVIP. Dilengkapi dengan pelayanan keperawatan 24 jam, dokter visite harian, serta fasilitas penunjang yang Islami dan bersih.',
                'priority'  => 10,
                'is_active' => true,
            ],

            // MCU (MEDICAL CHECK UP)
            [
                'category'  => 'Fasilitas & Layanan',
                'intent'    => 'mcu',
                'question'  => 'Pemeriksaan Kesehatan / Medical Check Up (MCU)',
                'keywords'  => 'mcu, medical, check, up, pemeriksaan, tes, kesehatan, lab, darah, paket, kerja, nikah',
                'synonyms'  => 'medical check up, tes kesehatan kerja, paket mcu',
                'answer'    => 'RSU Fikri Medika melayani <strong>Medical Check Up (MCU)</strong> untuk keperluan pribadi, calon karyawan instansi/perusahaan, pemeriksaan pranikah, serta tes kesehatan berkala.<br><br>Informasi paket MCU lengkap dapat ditanyakan di loket informasi atau Customer Service kami.',
                'priority'  => 10,
                'is_active' => true,
            ],

            // LOKASI & ALAMAT
            [
                'category'  => 'Kontak & Lokasi',
                'intent'    => 'lokasi',
                'question'  => 'Alamat & Lokasi RSU Fikri Medika',
                'keywords'  => 'lokasi, alamat, tempat, daerah, karawang, dimana, peta, rute, google maps',
                'synonyms'  => 'alamat rsu fikri medika, dimana rsu fikri medika, peta lokasi rumah sakit',
                'answer'    => '📍 <strong>Lokasi RSU Fikri Medika Karawang</strong><br><br>Jl. Raya Kosambi - Telagasari, Karawang, Jawa Barat.<br><br>Anda dapat melihat petunjuk rute di halaman <a href="/kontak" class="font-bold underline text-[#0e7c47]">Kontak & Peta Lokasi</a> atau langsung melalui Google Maps.',
                'priority'  => 10,
                'is_active' => true,
            ],

            // KONTAK & CALL CENTER
            [
                'category'  => 'Kontak & Lokasi',
                'intent'    => 'kontak',
                'question'  => 'Kontak, Telepon & Call Center RSU Fikri Medika',
                'keywords'  => 'kontak, telepon, call center, no hp, whatsapp, wa, email, customer service, cs, hubungi',
                'synonyms'  => 'nomor telepon rs, whatsapp rsu fikri medika, no hp rumah sakit',
                'answer'    => '📞 <strong>Kontak RSU Fikri Medika</strong><br><br>• Call Center / Pendaftaran: <strong>(0267) 8454999</strong><br>• Emergency IGD: <strong>(0267) 8454999</strong><br>• Email: <strong>fikri.medika@gmail.com</strong><br><br>Tim kami siap membantu Anda.',
                'priority'  => 10,
                'is_active' => true,
            ],

            // DISCLAIMER KONSULTASI MEDIS / OBAT
            [
                'category'  => 'Keamanan Medis',
                'intent'    => 'konsultasi_medis',
                'question'  => 'Pertanyaan Diagnosa / Keluhan Sakit / Resep Obat',
                'keywords'  => 'sakit, nyeri, pusing, batuk, demam, mual, minum, obat, resep, penyakit, dokter, diagnosis',
                'synonyms'  => 'saya sakit perut obatnya apa, konsultasi medis online, gejala penyakit',
                'answer'    => '⚠️ <strong>Informasi Penting Medis:</strong><br><br>Sebagai asisten virtual, Tanya Fikri tidak dapat memberikan diagnosis medis atau resep obat.<br><br>Untuk penanganan dan pengobatan yang tepat dan aman, sangat disarankan untuk berkonsultasi langsung dengan <strong>Dokter Spesialis RSU Fikri Medika</strong>.<br><br>Silakan cek jadwal praktik di halaman <a href="/jadwal-dokter" class="font-bold underline text-[#0e7c47]">Jadwal Dokter</a>.',
                'priority'  => 25,
                'is_active' => true,
            ],
        ];

        foreach ($kbData as $data) {
            KnowledgeBase::updateOrCreate(
                ['intent' => $data['intent']],
                $data
            );
        }
    }
}
