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
        KnowledgeBase::truncate();

        $kbData = [
            // 1. GREETING
            [
                'category'  => 'Umum',
                'intent'    => 'greeting',
                'question'  => 'Salam & Sapaan Pengunjung',
                'keywords'  => 'halo, hai, hi, helo, assalamualaikum, salam, fikri, kaka fikri, pagi, siang, sore, malam, selamat pagi, selamat siang, selamat malam',
                'synonyms'  => 'halo kaka fikri, hai fikri, assalamu alaikum, tes, ping, halo rs fikri',
                'answer'    => 'Halo 👋 Selamat datang di <strong>RSU Fikri Medika Karawang</strong>! Saya <strong>Kakak Fikri</strong>, asisten virtual resmi Anda.<br><br>Saya dapat membantu Anda mencari informasi mengenai:<br>• 👨‍⚕️ <strong>Jadwal Dokter & Poliklinik</strong><br>• 📋 <strong>Pendaftaran Rawat Jalan & Online</strong><br>• 🏥 <strong>Fasilitas Rawat Inap & Kamar VIP</strong><br>• 💳 <strong>Layanan Pasien BPJS & Asuransi</strong><br>• 🩺 <strong>Paket Medical Check Up (MCU)</strong><br>• 🚨 <strong>Layanan IGD 24 Jam & Ambulans</strong><br><br>Ada yang bisa saya bantu untuk Anda hari ini? 😊',
                'priority'  => 100,
                'is_active' => true,
            ],

            // 2. JAM OPERASIONAL / JAM BUKA
            [
                'category'  => 'Umum',
                'intent'    => 'hospital_hours',
                'question'  => 'Jam Buka & Operasional RSU Fikri Medika',
                'keywords'  => 'jam buka, jam operasional, buka jam berapa, tutup jam berapa, rs buka, buka hari minggu, minggu buka, buka malam, masih buka, malam masih buka, hari libur buka, jam kerja, jadwal buka, pelayanan buka, jam bukanya kapan, kapan buka',
                'synonyms'  => 'apakah hari minggu buka, rs fikri buka 24 jam, jadwal operasional rumah sakit, sampai jam berapa buka, minggu ada dokter, kalau malam masih buka',
                'answer'    => '🕒 <strong>Jam Operasional RSU Fikri Medika Karawang:</strong><br><br>• 🚨 <strong>IGD & Ambulans:</strong> Buka <strong>24 Jam Nonstop</strong> setiap hari (termasuk hari libur/Minggu).<br>• 💊 <strong>Farmasi & Laboratorium:</strong> Siaga <strong>24 Jam</strong>.<br>• 🏥 <strong>Poliklinik Rawat Jalan:</strong> Beroperasi <strong>Senin s/d Sabtu</strong> (Pagi 08.00 - Malam 21.00 WIB sesuai jadwal dokter spesialis).<br>• 📅 <strong>Hari Minggu / Libur Nasional:</strong> Layanan darurat IGD tetap buka 24 jam penuh.',
                'priority'  => 95,
                'is_active' => true,
            ],

            // 3. PROFIL & TENTANG RUMAH SAKIT
            [
                'category'  => 'Profil RS',
                'intent'    => 'hospital_profile',
                'question'  => 'Profil & Sejarah RSU Fikri Medika Karawang',
                'keywords'  => 'profil, sejarah, tentang, visi, misi, tipe, rumah sakit, pt karya mandiri medika utama, owner, direktur, akreditasi',
                'synonyms'  => 'mengenai rsu fikri medika, tentang rumah sakit fikri, siapa pemilik rs fikri',
                'answer'    => '🏥 <strong>RSU Fikri Medika Karawang</strong> bernaung di bawah <strong>PT. Karya Mandiri Medika Utama</strong>.<br><br>Kami merupakan rumah sakit modern bernuansa Islami yang menyediakan pelayanan kesehatan terpadu dan berkualitas tinggi dengan motto <em>"Professional, Islami, Caring, Integrity, Modern"</em>. Dilengkapi fasilitas modern seperti Trauma Center, Spesialis Mata Bedah Katarak, Kemilau Cinta Ibu & Anak, CT Scan, ICU, Hemodialisa, dan Laboratorium 24 Jam.',
                'priority'  => 80,
                'is_active' => true,
            ],

            // 4. LOKASI & ALAMAT
            [
                'category'  => 'Kontak & Lokasi',
                'intent'    => 'hospital_location',
                'question'  => 'Alamat & Petunjuk Arah Lokasi RSU Fikri Medika',
                'keywords'  => 'lokasi, alamat, peta, maps, jalan, arah, rute, dimana, daerah mana, karawang, kosambi, klari, patokan',
                'synonyms'  => 'alamat rsu fikri medika, lokasi rumah sakit fikri, rute ke rs fikri, google maps rs fikri',
                'answer'    => '📍 <strong>Lokasi RSU Fikri Medika Karawang:</strong><br><br>Jl. Raya Kosambi - Telagasari No. 1, Duren, Kec. Klari, Kabupaten Karawang, Jawa Barat 41371.<br><br>Patokan: Sangat strategis dan mudah diakses dari arah Karawang Kota maupun Telagasari/Cikampek via Jalur Kosambi.',
                'priority'  => 85,
                'is_active' => true,
            ],

            // 5. KONTAK, TELEPON & WHATSAPP
            [
                'category'  => 'Kontak & Lokasi',
                'intent'    => 'hospital_contact',
                'question'  => 'Nomor Telepon, WhatsApp & Call Center RS',
                'keywords'  => 'telepon, kontak, wa, whatsapp, nomor, call center, no hp, email, customer service, hubungi, cs',
                'synonyms'  => 'nomor wa rs fikri, nomor telepon rumah sakit fikri, no telepon cs fikri medika',
                'answer'    => '📞 <strong>Kontak Resmi RSU Fikri Medika Karawang:</strong><br><br>• ☎️ <strong>Call Center / Telepon:</strong> (0267) 8615555 / (0267) 8454999<br>• 💬 <strong>WhatsApp Info & Pendaftaran:</strong> 0822-8074-9999<br>• 🚨 <strong>Emergency IGD 24 Jam:</strong> (0267) 8454999<br>• ✉️ <strong>Email:</strong> info@rsufikrimedika.com',
                'priority'  => 85,
                'is_active' => true,
            ],

            // 6. IGD & GAWAT DARURAT
            [
                'category'  => 'Gawat Darurat',
                'intent'    => 'emergency',
                'question'  => 'Instalasi Gawat Darurat (IGD 24 Jam) & Cara ke IGD',
                'keywords'  => 'igd, ugd, darurat, emergency, kecelakaan, kritis, pertolongan, gawat darurat, butuh pertolongan, sesak nafas parah, pingsan, ambulans igd, cara ke igd, petunjuk igd, jalan ke igd',
                'synonyms'  => 'cara ke igd, nomor igd, unit gawat darurat, emergency call rs fikri, bagaimana cara ke igd, jalan ke igd',
                'answer'    => '🚨 <strong>Instalasi Gawat Darurat (IGD 24 Jam) RSU Fikri Medika</strong><br><br>Tim dokter jaga dan perawat terlatih siaga <strong>24 jam penuh</strong> untuk menangani kegawatdaruratan medis, trauma center kecelakaan kerja/lalu lintas, dan resusitasi darurat.<br><br>• ☎️ <strong>Emergency Call Hotline:</strong> <strong>(0267) 8454999</strong><br>• 🚑 <strong>Ambulans Jemput Pasien:</strong> <strong>0822-8074-9999</strong><br><br><em>Catatan: Pasien darurat dapat langsung datang ke area IGD di lobi depan barat tanpa perlu reservasi terlebih dahulu.</em>',
                'priority'  => 95,
                'is_active' => true,
            ],

            // 7. PENDAFTARAN BPJS KESEHATAN
            [
                'category'  => 'Pendaftaran & BPJS',
                'intent'    => 'registration_bpjs',
                'question'  => 'Syarat & Alur Pendaftaran Pasien BPJS Kesehatan',
                'keywords'  => 'bpjs, bpjs kesehatan, kis, jkn, faskes, rujukan, syarat bpjs, daftar bpjs, kartu bpjs, faskes 1, gratis bpjs, cover bpjs, cara menggunakan bpjs, bagaimana menggunakan bpjs, pakai bpjs, berobat bpjs',
                'synonyms'  => 'apakah menerima bpjs, cara berobat pakai bpjs, persyaratan bpjs kesehatan, rujukan puskesmas ke rs fikri, bagaimana cara menggunakan bpjs, cara pakai bpjs kesehatan',
                'answer'    => '✅ <strong>RSU Fikri Medika melayani pasien BPJS Kesehatan / KIS.</strong><br><br>📋 <strong>Persyaratan Berkas Rawat Jalan BPJS:</strong><br>1. Kartu BPJS Kesehatan / KIS aktif (asli / KIS Digital di aplikasi Mobile JKN).<br>2. Surat Rujukan online yang masih aktif dari Faskes Tingkat 1 (Puskesmas/Klinik).<br>3. KTP dan Kartu Keluarga (KK).<br><br>💡 <em>Untuk kondisi gawat darurat (IGD), pasien BPJS dapat langsung dilayani tanpa surat rujukan!</em>',
                'priority'  => 95,
                'is_active' => true,
            ],

            // 8. PENDAFTARAN ONLINE & BUAT JANJI
            [
                'category'  => 'Pendaftaran',
                'intent'    => 'registration_online',
                'question'  => 'Cara Pendaftaran Online & Buat Janji Dokter',
                'keywords'  => 'daftar online, cara daftar online, buat janji, booking, reservasi, jadwal temu, appointment, registrasi online, antrean online, bagaimana cara daftar online',
                'synonyms'  => 'bagaimana cara daftar online, saya mau buat janji dokter, booking dokter online, pendaftaran pasien baru online, registrasi dokter online',
                'answer'    => '📱 <strong>Cara Pendaftaran Online / Buat Janji Temu Dokter:</strong><br><br>1. 🌐 <strong>Melalui Website:</strong> Kunjungi menu <a href="/buat-janji" class="text-[#0e7c47] font-bold underline">Buat Janji Online</a>, pilih poliklinik & dokter spesialis yang diinginkan.<br>2. 💬 <strong>Melalui WhatsApp Resmi:</strong> Kirim pesan ke WhatsApp <strong>0822-8074-9999</strong> dengan format: <em>Nama Pasien # No RM/KTP # Poli Dituju # Hari/Tgl Kunjungan</em>.<br><br>Pendaftaran online disarankan H-1 sebelum jadwal praktik dokter untuk kenyamanan antrean Anda.',
                'priority'  => 90,
                'is_active' => true,
            ],

            // 9. PENDAFTARAN UMUM & RAWAT JALAN
            [
                'category'  => 'Pendaftaran',
                'intent'    => 'outpatient',
                'question'  => 'Pelayanan Rawat Jalan & Poliklinik Spesialis',
                'keywords'  => 'rawat jalan, poliklinik, poli, periksa ke dokter, berobat, konsultasi dokter, poli spesialis, loket pendaftaran, saya mau daftar rawat jalan',
                'synonyms'  => 'saya mau daftar rawat jalan, pelayanan rawat jalan rs fikri, cara periksa ke poliklinik, daftar poli rawat jalan',
                'answer'    => '🏥 <strong>Instalasi Rawat Jalan RSU Fikri Medika</strong><br><br>Menyediakan layanan konsultasi dan tindakan medis dari 12+ poliklinik spesialis:<br>• Spesialis Penyakit Dalam, Anak (Pediatri), Kandungan & Kebidanan (Obgyn), Bedah Umum, Jantung & Pembuluh Darah, Paru, Bedah Saraf, Mata, THT, Gigi Spesialis, dan Psikiatri.<br><br>Pelayanan buka Senin - Sabtu. Pendaftaran dapat dilakukan langsung di loket admisi atau secara online.',
                'priority'  => 85,
                'is_active' => true,
            ],

            // 10. RAWAT INAP & INFORMASI KAMAR
            [
                'category'  => 'Rawat Inap',
                'intent'    => 'inpatient',
                'question'  => 'Fasilitas Rawat Inap & Pilihan Kamar Pasien (VIP, VVIP, Kelas 1-3)',
                'keywords'  => 'rawat inap, inap, kamar, opname, kelas vip, vvip, kelas 1, kelas 2, kelas 3, kamar rawat, fasilitas kamar, sewa kamar, daftar rawat inap, cara daftar rawat inap, bagaimana cara daftar rawat inap',
                'synonyms'  => 'apakah ada kamar vip, fasilitas rawat inap, berapa biaya rawat inap, syarat rawat inap, bagaimana cara daftar rawat inap, daftar kamar inap',
                'answer'    => '🛏️ <strong>Fasilitas Rawat Inap RSU Fikri Medika Karawang:</strong><br><br>Kami menyediakan berbagai pilihan kelas perawatan yang bersih, nyaman, dan higienis:<br>• 🌟 <strong>Kamar VVIP & VIP:</strong> 1 Bed pasien elektrik, Smart TV, AC, Kulkas, Sofa penunggu, Kamar mandi privat dengan water heater, & paket amenities lengkap.<br>• 🛏️ <strong>Kelas 1:</strong> 2 Bed/ruangan ber-AC dengan sekat privasi.<br>• 🛏️ <strong>Kelas 2 & Kelas 3:</strong> Ruangan ber-AC nyaman sesuai standar BPJS (KRIS).<br>• 🏥 <strong>ICU & Perinatologi:</strong> Ruang perawatan intensif dengan pemantauan monitor hemodinamik modern 24 jam.',
                'priority'  => 90,
                'is_active' => true,
            ],

            // 11. MEDICAL CHECK UP (MCU)
            [
                'category'  => 'Fasilitas & Layanan',
                'intent'    => 'mcu',
                'question'  => 'Layanan & Paket Medical Check Up (MCU)',
                'keywords'  => 'mcu, medical check up, cek kesehatan, tes darah, paket mcu, harga mcu, biaya mcu, mcu karyawan, mcu pra nikah, surat sehat',
                'synonyms'  => 'ada layanan mcu, berapa harga mcu, paket tes kesehatan, cek lab lengkap mcu',
                'answer'    => '🩺 <strong>Layanan Medical Check Up (MCU) RSU Fikri Medika:</strong><br><br>Kami melayani pemeriksaan kesehatan menyeluruh dengan hasil cepat dan akurat:<br>• 💼 <strong>Paket Calon Karyawan & Berkala Perusahaan</strong><br>• 💍 <strong>Paket Pra-Nikah (Premarital Check Up)</strong><br>• 🏃‍♂️ <strong>Paket Sehat Dasar, Standar, & Executive</strong><br>• 📄 <strong>Pemeriksaan Bebas Narkoba & Surat Sehat Dokter</strong><br><br>Konsultasi paket & reservasi MCU dapat menghubungi WhatsApp CS di <strong>0822-8074-9999</strong>.',
                'priority'  => 85,
                'is_active' => true,
            ],

            // 12. LAYANAN UNGGULAN
            [
                'category'  => 'Layanan Unggulan',
                'intent'    => 'service_search',
                'question'  => 'Daftar Layanan Unggulan RSU Fikri Medika',
                'keywords'  => 'layanan unggulan, apa saja layanan unggulan, unggulan, center of excellence, kemilau cinta, trauma center, spesialis mata, katarak, antar jemput',
                'synonyms'  => 'program unggulan rumah sakit, keunggulan rsu fikri medika',
                'answer'    => '🌟 <strong>4 Layanan Unggulan RSU Fikri Medika Karawang:</strong><br><br>1. 🚑 <strong>Trauma Center 24 Jam:</strong> Penanganan cedera kecelakaan kerja, patah tulang, dan trauma fisik terpadu bersama BPJS Ketenagakerjaan & Jasa Raharja.<br>2. 👶 <strong>Kemilau Cinta (Layanan Ibu & Anak):</strong> Persalinan nyaman (metode ERACS), rawat gabung Islami, imunisasi lengkap, dan USG 4D.<br>3. 👁️ <strong>Layanan Spesialis Mata:</strong> Operasi katarak modern metode Phacoemulsifikasi (tanpa jahitan) & pemeriksaan refraksi optik digital.<br>4. 🚐 <strong>Antar Jemput Pasien:</strong> Penjemputan ambulans medis siaga bagi pasien darurat maupun rawat inap.',
                'priority'  => 90,
                'is_active' => true,
            ],

            // 13. SPESIALIS MATA & OPERASI KATARAK
            [
                'category'  => 'Layanan Unggulan',
                'intent'    => 'spesialis_mata',
                'question'  => 'Layanan Spesialis Mata & Bedah Katarak Modern',
                'keywords'  => 'mata, dokter mata, spesialis mata, katarak, operasi katarak, phaco, periksa mata, minus, silinder, mata buram, laser mata',
                'synonyms'  => 'ada dokter mata, dokter spesialis mata siapa saja, poli mata',
                'answer'    => '👁️ <strong>Layanan Spesialis Mata RSU Fikri Medika:</strong><br><br>Kami didukung dokter spesialis mata berpengalaman serta fasilitas diagnostik modern:<br>• Operasi Katarak metode <em>Phacoemulsification</em> (canggih, cepat, tanpa jahitan).<br>• Pemeriksaan Slit Lamp Digital, Tonometri (Tekanan Bola Mata), dan Refraksi Visus.<br>• Penanganan glaukoma, infeksi mata, dan gangguan retina.<br><br>Melayani pasien Umum, Asuransi, dan BPJS Kesehatan (dengan rujukan).',
                'priority'  => 90,
                'is_active' => true,
            ],

            // 14. KEMILAU CINTA IBU & ANAK
            [
                'category'  => 'Layanan Unggulan',
                'intent'    => 'kemilau_cinta',
                'question'  => 'Program Kemilau Cinta (Layanan Persalinan, Kebidanan & Anak)',
                'keywords'  => 'kemilau cinta, ibu anak, persalinan, melahirkan, melahirkan eracs, usg 4d, bidan, poli kandungan, spog, obgyn, dokter anak, imunisasi, bayi',
                'synonyms'  => 'paket melahirkan, biaya melahirkan di rs fikri, persalinan eracs karawang, periksa usg 4d',
                'answer'    => '👶 <strong>Kemilau Cinta RSU Fikri Medika:</strong><br><br>Pelayanan komprehensif bagi Ibu & Buah Hati tercinta:<br>• 🌸 <strong>Persalinan Metode ERACS:</strong> Pemulihan pasca operasi caesar yang jauh lebih cepat, nyaman, dan minim nyeri.<br>• 📸 <strong>Pemeriksaan USG 4D Live HD:</strong> Melihat gerak dan wajah janin secara nyata dan jelas.<br>• 💉 <strong>Klinik Tumbuh Kembang & Imunisasi Anak Lengkap.</strong><br>• 🤱 Ruang laktasi dan pendampingan ASI eksklusif.',
                'priority'  => 90,
                'is_active' => true,
            ],

            // 15. TRAUMA CENTER & KECELAKAAN KERJA
            [
                'category'  => 'Layanan Unggulan',
                'intent'    => 'trauma_center',
                'question'  => 'Trauma Center & Penanganan Kecelakaan Kerja BPJS TK',
                'keywords'  => 'trauma center, kecelakaan kerja, bpjs ketenagakerjaan, bpjs tk, jasa raharja, patah tulang, bedah tulang, ortopedi, tabrakan, luka berat',
                'synonyms'  => 'penanganan kecelakaan kerja, klaim bpjs ketenagakerjaan rs fikri',
                'answer'    => '🛡️ <strong>Trauma Center RSU Fikri Medika:</strong><br><br>Pusat penanganan terpadu untuk pasien kecelakaan lalu lintas maupun kecelakaan kerja industri di Karawang:<br>• Kerjasama resmi dengan <strong>BPJS Ketenagakerjaan</strong> dan <strong>PT. Jasa Raharja</strong>.<br>• Penanganan cepat oleh tim Dokter Bedah, Bedah Saraf, Radiologi CT Scan, dan Kamar Operasi CITO 24 Jam.<br>• Layanan pendampingan administrasi klaim kecelakaan kerja.',
                'priority'  => 85,
                'is_active' => true,
            ],

            // 16. FARMASI 24 JAM
            [
                'category'  => 'Penunjang Medis',
                'intent'    => 'pharmacy',
                'question'  => 'Instalasi Farmasi & Apotek 24 Jam',
                'keywords'  => 'farmasi, obat, apotek, tebus resep, beli obat, apoteker, farmasi 24 jam, obat resep',
                'synonyms'  => 'apotek buka 24 jam, beli obat di rs fikri, layanan farmasi',
                'answer'    => '💊 <strong>Instalasi Farmasi RSU Fikri Medika</strong> melayani penebusan resep obat rawat jalan, rawat inap, dan IGD selama <strong>24 Jam Penuh</strong>.<br><br>Kami menjamin ketersediaan obat bermutu, aman, serta dilengkapi pelayanan informasi obat (PIO) dan konseling oleh apoteker profesional berizin resmi.',
                'priority'  => 80,
                'is_active' => true,
            ],

            // 17. LABORATORIUM KLINIK 24 JAM
            [
                'category'  => 'Penunjang Medis',
                'intent'    => 'laboratory',
                'question'  => 'Laboratorium Klinik Terpadu 24 Jam',
                'keywords'  => 'laboratorium, lab, tes darah, cek darah, urine, kolesterol, gula darah, asam urat, patologi, lab 24 jam',
                'synonyms'  => 'cek laboratorium, biaya cek darah, hasil lab berapa lama',
                'answer'    => '🔬 <strong>Laboratorium Klinik RSU Fikri Medika:</strong><br><br>Beroperasi <strong>24 Jam</strong> dengan peralatan analisa otomatis mutakhir untuk akurasi dan kecepatan hasil:<br>• Hematologi Lengkap, Kimia Darah, Elektrolit, Gas Darah.<br>• Serologi, Imunologi, & Tes Hormon.<br>• Urinalisa, Feses, serta Mikrobiologi.<br><br>Hasil tes rutin darurat dapat selesai dalam waktu 30-60 menit.',
                'priority'  => 80,
                'is_active' => true,
            ],

            // 18. RADIOLOGI & CT SCAN
            [
                'category'  => 'Penunjang Medis',
                'intent'    => 'radiology',
                'question'  => 'Layanan Radiologi, Rontgen & CT Scan Digital',
                'keywords'  => 'radiologi, rontgen, ronsen, x-ray, ct scan, usg, usg perut, foto rontgen, radiologi 24 jam',
                'synonyms'  => 'ada rontgen, foto thorax, ct scan kepala',
                'answer'    => '🩻 <strong>Instalasi Radiologi RSU Fikri Medika (24 Jam):</strong><br><br>Fasilitas pencitraan medis canggih dengan radiasi minimal:<br>• <strong>CT Scan Digital Multi-Slice:</strong> Pemeriksaan detail otak, dada, dan abdomen.<br>• <strong>Rontgen X-Ray Digital:</strong> Foto toraks, tulang, dan sendi hasil instan.<br>• <strong>USG Abdomen & USG Doppler:</strong> Pemeriksaan organ dalam non-radiasi.',
                'priority'  => 80,
                'is_active' => true,
            ],

            // 19. ASURANSI SWASTA & PERUSAHAAN
            [
                'category'  => 'Asuransi & Pembayaran',
                'intent'    => 'insurance',
                'question'  => 'Daftar Asuransi Swasta & Rekanan Perusahaan',
                'keywords'  => 'asuransi, asuransi swasta, prudential, allianz, axa, sinarmas, admedika, cashless, klaim asuransi, rekanan perusahaan',
                'synonyms'  => 'apakah menerima asuransi swasta, asuransi apa saja yang bekerjasama, cara klaim asuransi',
                'answer'    => '💳 <strong>Kerjasama Asuransi & Korporasi:</strong><br><br>RSU Fikri Medika bekerjasama dengan berbagai asuransi terkemuka via sistem <strong>Cashless</strong> maupun Reimburse (AdMedika, Prudential, Sinarmas, Allianz, Mandiri Inhealth, Reliance, Astra Buana, dll.) serta puluhan perusahaan di kawasan industri Karawang.<br><br>Untuk konfirmasi coverage polis Anda, silakan hubungi bagian Asuransi/Admisi kami.',
                'priority'  => 80,
                'is_active' => true,
            ],

            // 20. AMBULANS & ANTAR JEMPUT
            [
                'category'  => 'Layanan Unggulan',
                'intent'    => 'ambulance',
                'question'  => 'Layanan Ambulans Medis & Antar Jemput Pasien',
                'keywords'  => 'ambulans, ambulance, jemput pasien, sewa ambulans, mobil jenazah, antar jemput, panggilan ambulans',
                'synonyms'  => 'nomor ambulans, butuh ambulans sekarang, penjemputan pasien sakit',
                'answer'    => '🚐 <strong>Layanan Ambulans 24 Jam RSU Fikri Medika:</strong><br><br>Armada ambulans kami dilengkapi perlengkapan medis darurat, tabung oksigen, monitor, dan didampingi perawat berpengalaman.<br><br>Melayani:<br>• Penjemputan pasien gawat darurat ke rumah/lokasi.<br>• Rujukan antar rumah sakit.<br>• Antar pulang pasien rawat inap.<br><br>📞 <strong>Hotline Ambulans:</strong> <strong>(0267) 8454999</strong> / WA: <strong>0822-8074-9999</strong>.',
                'priority'  => 85,
                'is_active' => true,
            ],

            // 21. FASILITAS UMUM (PARKIR, MUSHOLA, KANTIN)
            [
                'category'  => 'Fasilitas & Layanan',
                'intent'    => 'facilities',
                'question'  => 'Fasilitas Umum (Parkir, Mushola, Ruang Tunggu, ATM)',
                'keywords'  => 'fasilitas, parkir, parkir motor, parkir mobil, mushola, masjid, atm, kantin, wifi, ruang tunggu, toilet',
                'synonyms'  => 'dimana parkir motor, ada mushola, fasilitas umum rs fikri',
                'answer'    => '🏢 <strong>Fasilitas Umum RSU Fikri Medika:</strong><br><br>• 🅿️ <strong>Area Parkir:</strong> Parkir mobil dan motor luas, tertata rapi dengan keamanan CCTV 24 jam.<br>• 🕌 <strong>Mushola:</strong> Bersih, nyaman, ber-AC untuk ibadah pasien dan keluarga.<br>• ☕ <strong>Kantin & Minimarket:</strong> Menyediakan makanan higienis dan kebutuhan harian.<br>• 🏧 <strong>Galeri ATM & Free Wi-Fi</strong> di seluruh area ruang tunggu.',
                'priority'  => 75,
                'is_active' => true,
            ],

            // 22. KELUHAN, KRITIK & SARAN
            [
                'category'  => 'Bantuan & Customer Service',
                'intent'    => 'complaint',
                'question'  => 'Layanan Aduan Pelanggan, Kritik & Saran',
                'keywords'  => 'keluhan, komplain, kritik, saran, aduan, layanan pelanggan, customer care, tidak puas, laporkan',
                'synonyms'  => 'mau komplain pelayanan, nomor pengaduan rs fikri, layanan aduan pasien',
                'answer'    => '🤝 <strong>Layanan Pengaduan & Kepuasan Pelanggan:</strong><br><br>Kenyamanan dan kepuasan Anda adalah prioritas utama kami. Jika ada masukan, kritik, atau hal yang kurang berkenan selama pelayanan:<br><br>• 💬 <strong>WhatsApp Customer Care:</strong> <strong>0822-8074-9999</strong><br>• 🌐 <strong>Formulir Aduan Online:</strong> <a href="/informasi/aduan-layanan" class="text-[#0e7c47] font-bold underline">Menu Aduan Layanan</a> di website.<br>• ✉️ <strong>Email:</strong> customercare@rsufikrimedika.com',
                'priority'  => 80,
                'is_active' => true,
            ],

            // 23. KONSULTASI MEDIS / DISCLAIMER KESEHATAN
            [
                'category'  => 'Konsultasi Medis',
                'intent'    => 'medical_disclaimer',
                'question'  => 'Batasan Konsultasi Medis Online & Anjuran Dokter',
                'keywords'  => 'kenapa sakit, resep obat, obat apa, dosis, penyakit apa, diagnosa, sakit dada, sakit perut parah, pusing banget, sesak',
                'synonyms'  => 'saya sakit apa, obat sakit kepala apa, minta resep dokter',
                'answer'    => '⚠️ <strong>Pemberitahuan Medis Penting:</strong><br><br>Saya adalah <strong>Kakak Fikri</strong> (Asisten Virtual Rumah Sakit) dan <strong>bukan dokter</strong>. Saya tidak dapat memberikan diagnosis penyakit, dosis obat, maupun resep medis secara mandiri.<br><br>Jika Anda merasakan gejala sakit yang mengganggu atau membutuhkan pemeriksaan medis yang tepat, kami sangat menyarankan Anda untuk:<br>1. 🩺 Berkonsultasi langsung dengan <strong>Dokter Spesialis</strong> di Poliklinik RSU Fikri Medika.<br>2. 🚨 Segera ke <strong>IGD 24 Jam</strong> jika mengalami nyeri dada, sesak nafas parah, atau kondisi darurat lainnya.',
                'priority'  => 100,
                'is_active' => true,
            ],
        ];

        foreach ($kbData as $item) {
            KnowledgeBase::updateOrCreate(
                ['intent' => $item['intent']],
                $item
            );
        }
    }
}
