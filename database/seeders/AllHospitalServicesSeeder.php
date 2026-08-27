<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class AllHospitalServicesSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            // ─── 1. LAYANAN UNGGULAN ───
            [
                'name' => [
                    'id' => 'Trauma Center',
                    'en' => 'Trauma Center'
                ],
                'slug' => 'trauma-center',
                'short_description' => [
                    'id' => 'Pusat penanganan terpadu untuk pasien dengan cedera trauma, kecelakaan kerja (BPJS TK), kecelakaan lalu lintas, dan kegawatdaruratan bedah.',
                    'en' => 'Integrated center for trauma injury, work accidents, and emergency surgery.'
                ],
                'description' => [
                    'id' => 'Trauma Center RSU Fikri Medika adalah layanan unggulan komprehensif yang siap 24 jam dalam menangani kasus-kasus kegawatdaruratan trauma akibat kecelakaan lalu lintas, kecelakaan kerja, maupun cedera olahraga. Didukung oleh dokter spesialis bedah ortopedi, bedah umum, bedah saraf, dokter anestesi, serta perawat bersertifikasi kegawatdaruratan.',
                    'en' => 'RSU Fikri Medika Trauma Center is a 24/7 comprehensive service handling trauma cases.'
                ],
                'icon' => 'fa-solid fa-truck-medical',
                'image' => 'trauma-center.png',
                'gallery' => ['trauma-center.png', 'gedung2_web.jpg'],
                'is_featured' => true,
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => [
                    'id' => 'Kemilau Cinta (Layanan Ibu & Anak)',
                    'en' => 'Kemilau Cinta (Maternal & Child Care)'
                ],
                'slug' => 'kemilau-cinta-layanan-ibu-anak',
                'short_description' => [
                    'id' => 'Layanan terpadu kesehatan ibu dan anak, kehamilan, persalinan nyaman (ERACS), imunisasi, serta perawatan bayi baru lahir.',
                    'en' => 'Comprehensive maternal and pediatric care, ERACS delivery, and neonatal care.'
                ],
                'description' => [
                    'id' => 'Kemilau Cinta merupakan program layanan unggulan RSU Fikri Medika yang didedikasikan untuk kesehatan ibu hamil, melahirkan, serta tumbuh kembang bayi dan anak. Kami menyediakan metode persalinan minim nyeri ERACS (Enhanced Recovery After Cesarean Surgery), USG 4D HD-Live, NICU/PICU, klinik laktasi, dan pijat bayi bersertifikat.',
                    'en' => 'Kemilau Cinta is our dedicated maternal and child health program.'
                ],
                'icon' => 'fa-solid fa-baby',
                'image' => 'gedung1_web.jpg',
                'gallery' => ['gedung1_web.jpg', 'banner-igd.png'],
                'is_featured' => true,
                'is_active' => true,
                'order' => 2,
            ],
            [
                'name' => [
                    'id' => 'Layanan Spesialis Mata',
                    'en' => 'Eye & Ophthalmology Specialist Center'
                ],
                'slug' => 'layanan-spesialis-mata',
                'short_description' => [
                    'id' => 'Pusat diagnosis dan perawatan komprehensif kesehatan mata, katarak phacoemulsifikasi (tanpa jahitan), glaukoma, dan refraksi.',
                    'en' => 'Comprehensive ophthalmology care and sutureless phacoemulsification cataract surgery.'
                ],
                'description' => [
                    'id' => 'Layanan Spesialis Mata RSU Fikri Medika menghadirkan pemeriksaan mata modern dengan teknologi mutakhir. Melayani operasi katarak teknik Phacoemulsifikasi (sayatan minimal dan cepat pulih), pemeriksaan retina, skrining glaukoma, koreksi refraksi, dan penanganan gangguan mata anak maupun dewasa.',
                    'en' => 'Comprehensive eye care supported by state-of-the-art diagnostic equipment.'
                ],
                'icon' => 'fa-solid fa-eye',
                'image' => 'spesialis-mata.png',
                'gallery' => ['spesialis-mata.png', 'gedung1_web.jpg'],
                'is_featured' => true,
                'is_active' => true,
                'order' => 3,
            ],
            [
                'name' => [
                    'id' => 'Layanan Antar Jemput Pasien',
                    'en' => 'Patient Transport & Ambulance 24/7'
                ],
                'slug' => 'layanan-antar-jemput-pasien',
                'short_description' => [
                    'id' => 'Andalan siap siaga melayani antar jemput pasien darurat dan rujukan 24 jam dengan fasilitas medis lengkap di dalam ambulans.',
                    'en' => 'Ready 24/7 ambulance emergency transport equipped with medical support.'
                ],
                'description' => [
                    'id' => 'Armada ambulans RSU Fikri Medika siap 24 jam menjemput pasien dari rumah, lokasi kejadian, maupun rujukan antar faskes di wilayah Karawang dan sekitarnya. Didampingi oleh paramedis terlatih dan dilengkapi tabung oksigen, AED, monitor pasien, serta peralatan resusitasi darurat.',
                    'en' => '24/7 ambulance fleet ready to transport patients with life support equipment.'
                ],
                'icon' => 'fa-solid fa-ambulance',
                'image' => 'banner-igd.png',
                'gallery' => ['banner-igd.png', 'gedung2_web.jpg'],
                'is_featured' => true,
                'is_active' => true,
                'order' => 4,
            ],

            // ─── 2. LAYANAN UTAMA RUMAH SAKIT ───
            [
                'name' => [
                    'id' => 'Instalasi Gawat Darurat (IGD 24 Jam)',
                    'en' => 'Emergency Department (24/7 ER)'
                ],
                'slug' => 'igd',
                'short_description' => [
                    'id' => 'Pelayanan penanganan medis darurat 24 jam penuh cepat tanggap dengan dokter jaga bersertifikat ACLS/ATLS.',
                    'en' => '24/7 rapid emergency medical response with certified emergency doctors.'
                ],
                'description' => [
                    'id' => 'Instalasi Gawat Darurat (IGD) RSU Fikri Medika beroperasi 24 jam non-stop dengan sistem triase modern untuk memprioritaskan penanganan pasien sesuai tingkat kegawatannya. Dilengkapi ruang resusitasi, ruang tindakan bedah minor, ruang observasi, serta akses cepat ke laboratorium dan radiologi.',
                    'en' => 'Emergency Department operating 24/7 with modern triage system and dedicated resuscitation suites.'
                ],
                'icon' => 'fa-solid fa-heart-pulse',
                'image' => 'banner-igd.png',
                'gallery' => ['banner-igd.png', 'gedung1_web.jpg'],
                'is_featured' => false,
                'is_active' => true,
                'order' => 5,
            ],
            [
                'name' => [
                    'id' => 'Instalasi Rawat Inap',
                    'en' => 'Inpatient Care Facilities'
                ],
                'slug' => 'rawat-inap',
                'short_description' => [
                    'id' => 'Kenyamanan ruang rawat inap higienis dengan pemantauan perawat 24 jam, mulai dari Kelas VVIP, VIP, Kelas 1, 2, hingga Kelas 3.',
                    'en' => 'Comfortable and hygienic inpatient rooms with round-the-clock nursing care.'
                ],
                'description' => [
                    'id' => 'Instalasi Rawat Inap RSU Fikri Medika dirancang dengan suasana yang nyaman, bersih, tenang, dan asri untuk menunjang proses penyembuhan pasien secara optimal. Dilengkapi fasilitas bel pemanggil perawat otomatis, pendingin ruangan (AC), televisi, sofa penunggu, serta pemantauan dokter penanggung jawab pelayanan (DPJP) setiap hari.',
                    'en' => 'Inpatient facilities designed to promote healing with full comfort and 24/7 medical supervision.'
                ],
                'icon' => 'fa-solid fa-bed-pulse',
                'image' => 'gedung2_web.jpg',
                'gallery' => ['gedung2_web.jpg', 'gedung1_web.jpg'],
                'is_featured' => false,
                'is_active' => true,
                'order' => 6,
            ],
            [
                'name' => [
                    'id' => 'Klinik Rawat Jalan (Poliklinik Spesialis)',
                    'en' => 'Outpatient Specialist Polyclinic'
                ],
                'slug' => 'rawat-jalan',
                'short_description' => [
                    'id' => 'Konsultasi medis dan pemeriksaan kesehatan oleh dokter spesialis lengkap (Penyakit Dalam, Anak, Kandungan, Bedah, Jantung, dll).',
                    'en' => 'Specialist medical consultations across cardiology, pediatric, obgyn, internal medicine, and surgery.'
                ],
                'description' => [
                    'id' => 'Klinik Rawat Jalan RSU Fikri Medika melayani berbagai konsultasi dan pemeriksaan dokter spesialis dan subspesialis dengan ruang tunggu yang nyaman, pendingin ruangan, sistem pendaftaran terintegrasi, dan antrean digital yang transparan.',
                    'en' => 'Outpatient clinics offering consultations with comprehensive specialist doctors.'
                ],
                'icon' => 'fa-solid fa-stethoscope',
                'image' => 'gedung1_web.jpg',
                'gallery' => ['gedung1_web.jpg', 'gedung2_web.jpg'],
                'is_featured' => false,
                'is_active' => true,
                'order' => 7,
            ],
            [
                'name' => [
                    'id' => 'Instalasi Rehabilitasi Medik',
                    'en' => 'Medical Rehabilitation & Physical Therapy'
                ],
                'slug' => 'rehabilitasi-medik',
                'short_description' => [
                    'id' => 'Layanan fisioterapi, terapi okupasi, dan pemulihan fungsi motorik tubuh pasca stroke, cedera tulang, maupun pasca operasi.',
                    'en' => 'Physical therapy, occupational therapy, and motor recovery services.'
                ],
                'description' => [
                    'id' => 'Instalasi Rehabilitasi Medik RSU Fikri Medika membantu memulihkan kemampuan fisik dan kemandirian fungsional pasien melalui program fisioterapi komprehensif. Dilengkapi alat elektroterapi (TENS, MWD, Ultrasound), traksi lumbal/servikal, serta latihan gerak terpadu yang dipandu oleh fisioterapis profesional.',
                    'en' => 'Medical rehabilitation center offering physical and occupational therapies.'
                ],
                'icon' => 'fa-solid fa-person-walking-with-cane',
                'image' => 'gedung2_web.jpg',
                'gallery' => ['gedung2_web.jpg', 'gedung1_web.jpg'],
                'is_featured' => false,
                'is_active' => true,
                'order' => 8,
            ],
            [
                'name' => [
                    'id' => 'Pelayanan Farmasi 24 Jam',
                    'en' => '24/7 Pharmacy & Clinical Medication'
                ],
                'slug' => 'farmasi-24-jam',
                'short_description' => [
                    'id' => 'Instalasi Farmasi rumah sakit siap 24 jam menyediakan obat-obatan resep dokter, obat bebas, dan konseling informasi obat oleh apoteker.',
                    'en' => 'Round-the-clock pharmacy dispensing prescription medicine and professional medication counseling.'
                ],
                'description' => [
                    'id' => 'Instalasi Farmasi RSU Fikri Medika beroperasi 24 jam non-stop untuk melayani kebutuhan obat pasien rawat jalan, rawat inap, dan IGD. Menjamin keaslian, penyimpanan standar suhu obat, serta edukasi cara konsumsi obat (Pelayanan Informasi Obat / PIO) oleh Apoteker yang bertugas.',
                    'en' => '24/7 hospital pharmacy ensuring medication safety, authenticity, and patient counseling.'
                ],
                'icon' => 'fa-solid fa-pills',
                'image' => 'gedung1_web.jpg',
                'gallery' => ['gedung1_web.jpg', 'gedung2_web.jpg'],
                'is_featured' => false,
                'is_active' => true,
                'order' => 9,
            ],

            // ─── 3. PENUNJANG MEDIS ───
            [
                'name' => [
                    'id' => 'Layanan Penunjang Medis Terpadu',
                    'en' => 'Integrated Medical Diagnostic Support'
                ],
                'slug' => 'penunjang-medis',
                'short_description' => [
                    'id' => 'Rangkaian fasilitas diagnostik medis modern pendukung diagnosa dokter: Radiologi, Laboratorium Klinik, Patologi, dan Gizi.',
                    'en' => 'Comprehensive diagnostic support: Radiology, Clinical Lab, Pathology, and Nutrition.'
                ],
                'description' => [
                    'id' => 'Layanan Penunjang Medis RSU Fikri Medika memberikan dukungan diagnostik akurat untuk mempercepat dan mempertegas diagnosa klinis dokter penanggung jawab. Meliputi Instalasi Radiologi 24 Jam, Laboratorium Klinik Terpadu, Patologi Anatomi, dan Instalasi Gizi.',
                    'en' => 'Diagnostic medical support providing fast and accurate laboratory and radiology results.'
                ],
                'icon' => 'fa-solid fa-microscope',
                'image' => 'gedung2_web.jpg',
                'gallery' => ['gedung2_web.jpg', 'gedung1_web.jpg'],
                'is_featured' => false,
                'is_active' => true,
                'order' => 10,
            ],
            [
                'name' => [
                    'id' => 'Instalasi Radiologi 24 Jam',
                    'en' => '24/7 Radiology & Medical Imaging'
                ],
                'slug' => 'radiologi-24-jam',
                'short_description' => [
                    'id' => 'Pencitraan diagnostik medis digital (Rontgen Digital X-Ray, Panoramic Gigi, USG 4D, dan CT Scan) 24 jam.',
                    'en' => 'Digital X-Ray, Panoramic, 4D Ultrasound, and CT Scan imaging services.'
                ],
                'description' => [
                    'id' => 'Instalasi Radiologi RSU Fikri Medika dilengkapi dengan modalitas pencitraan mutakhir untuk menghasilkan gambar radiografi beresolusi tinggi dengan dosis radiasi yang aman bagi pasien. Hasil pembacaan dianalisis langsung oleh Dokter Spesialis Radiologi.',
                    'en' => 'Radiology department equipped with modern digital imaging and interpreted by radiologists.'
                ],
                'icon' => 'fa-solid fa-x-ray',
                'image' => 'gedung1_web.jpg',
                'gallery' => ['gedung1_web.jpg', 'gedung2_web.jpg'],
                'is_featured' => false,
                'is_active' => true,
                'order' => 11,
            ],
            [
                'name' => [
                    'id' => 'Laboratorium Klinik 24 Jam',
                    'en' => '24/7 Clinical Pathology Laboratory'
                ],
                'slug' => 'laboratorium-klinik',
                'short_description' => [
                    'id' => 'Pemeriksaan darah lengkap, kimia darah, elektrolit, serologi, dan urine dengan instrumen otomatisasi cepat dan presisi.',
                    'en' => 'Comprehensive hematology, biochemistry, immunology, and urine testing.'
                ],
                'description' => [
                    'id' => 'Laboratorium Klinik RSU Fikri Medika beroperasi 24 jam dengan kontrol kualitas (Quality Control) ketat. Melayani tes darah lengkap, profil lipid, fungsi hati/ginjal, gula darah, panel hepatitis, tes tiroid, dan skrining penyakit infeksi dengan waktu tunggu hasil yang cepat.',
                    'en' => '24/7 clinical laboratory running automated analyzers under strict quality control.'
                ],
                'icon' => 'fa-solid fa-flask-vial',
                'image' => 'gedung2_web.jpg',
                'gallery' => ['gedung2_web.jpg', 'gedung1_web.jpg'],
                'is_featured' => false,
                'is_active' => true,
                'order' => 12,
            ],
            [
                'name' => [
                    'id' => 'Laboratorium Patologi Anatomi',
                    'en' => 'Anatomical Pathology Laboratory'
                ],
                'slug' => 'laboratorium-patologi',
                'short_description' => [
                    'id' => 'Pemeriksaan biopsi jaringan, histopatologi, dan sitologi (Pap Smear & FNAB) untuk deteksi sel tumor dan jaringan abnormal.',
                    'en' => 'Histopathology biopsy, cytology, and tissue examination.'
                ],
                'description' => [
                    'id' => 'Laboratorium Patologi Anatomi RSU Fikri Medika melayani pemeriksaan spesimen jaringan tubuh (biopsi dan operasi), pemeriksaan cairan tubuh (sitologi), Pap Smear untuk skrining kanker serviks, serta Fine Needle Aspiration Biopsy (FNAB) yang dibaca oleh Dokter Spesialis Patologi Anatomi.',
                    'en' => 'Anatomical pathology laboratory providing biopsy, cytology, and tumor diagnostic services.'
                ],
                'icon' => 'fa-solid fa-vial-circle-check',
                'image' => 'gedung1_web.jpg',
                'gallery' => ['gedung1_web.jpg', 'gedung2_web.jpg'],
                'is_featured' => false,
                'is_active' => true,
                'order' => 13,
            ],
        ];

        foreach ($services as $serv) {
            Service::updateOrCreate(
                ['slug' => $serv['slug']],
                $serv
            );
        }
    }
}
