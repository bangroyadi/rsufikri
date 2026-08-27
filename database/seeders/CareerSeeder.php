<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Career;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CareerSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create or update HRD user
        User::updateOrCreate(
            ['email' => 'hrd@rsufikrimedika.com'],
            [
                'name' => 'HRD RSU Fikri Medika',
                'password' => Hash::make('hrdfikri2026'),
                'role' => 'hrd',
            ]
        );

        // Ensure admin user has role 'admin'
        User::where('email', 'admin@rsufikrimedika.com')->update(['role' => 'admin']);

        // 2. Sample Career Vacancies
        $careers = [
            [
                'title' => [
                    'id' => 'Perawat Pelaksana Rawat Inap & IGD',
                    'en' => 'Inpatient & ER Staff Nurse',
                ],
                'slug' => 'perawat-pelaksana-rawat-inap-igd',
                'department' => 'Keperawatan',
                'employment_type' => 'Full Time',
                'education_level' => 'D3 Keperawatan / Profesi Ners',
                'experience_years' => 'Fresh Graduate / 1-2 Tahun',
                'location' => 'RSU Fikri Medika, Karawang',
                'quota' => '5 Orang',
                'short_description' => [
                    'id' => 'Bertanggung jawab dalam memberikan asuhan keperawatan profesional dan komprehensif kepada pasien rawat inap dan IGD sesuai standar keselamatan pasien.',
                    'en' => 'Responsible for providing professional nursing care in inpatient and emergency departments.',
                ],
                'description' => [
                    'id' => 'RSU Fikri Medika membuka kesempatan bagi Tenaga Keperawatan yang berdedikasi tinggi, berintegritas, dan memiliki semangat melayani dengan hati untuk bergabung dalam tim medis kami yang dinamis.',
                    'en' => 'RSU Fikri Medika opens opportunities for dedicated nurses to join our team.',
                ],
                'requirements' => [
                    'Pendidikan minimal D3 Keperawatan atau Profesi Ners dari institusi terakreditasi',
                    'Memiliki STR (Surat Tanda Registrasi) aktif yang masih berlaku',
                    'Memiliki sertifikat BTCLS / PPGD yang masih aktif',
                    'Mampu bekerja dalam sistem shift (Pagi, Siang, Malam)',
                    'Memiliki komunikasi terapeutik yang baik, ramah, dan berorientasi pada keselamatan pasien',
                    'Sehat jasmani dan rohani, bebas narkoba',
                ],
                'responsibilities' => [
                    'Melakukan pengkajian awal dan asuhan keperawatan pasien secara tepat',
                    'Melaksanakan tindakan medis keperawatan sesuai advis dokter penanggung jawab',
                    'Memantau dan mencatat tanda-tanda vital serta perkembangan kondisi pasien',
                    'Melakukan edukasi kesehatan kepada pasien dan keluarga',
                    'Menjaga kebersihan, keselamatan, dan kerapihan lingkungan kerja',
                ],
                'benefits' => [
                    'Gaji Pokok & Tunjangan Pelayanan Medis',
                    'BPJS Kesehatan & BPJS Ketenagakerjaan',
                    'Pelatihan & Sertifikasi Berkelanjutan',
                    'Insentif Shift & Jenjang Karir Profesional',
                ],
                'deadline' => now()->addMonths(2)->format('Y-m-d'),
                'status' => 'open',
                'is_featured' => true,
                'is_active' => true,
                'order' => 1,
            ],
            [
                'title' => [
                    'id' => 'Apoteker Pendamping & Pelayanan Farmasi',
                    'en' => 'Pharmacist & Clinical Pharmacy Staff',
                ],
                'slug' => 'apoteker-pendamping-pelayanan-farmasi',
                'department' => 'Farmasi',
                'employment_type' => 'Full Time',
                'education_level' => 'Profesi Apoteker (S.Farm., Apt.)',
                'experience_years' => 'Minimal 1 Tahun (Fresh Graduate dipersilakan)',
                'location' => 'Instalasi Farmasi RSU Fikri Medika',
                'quota' => '2 Orang',
                'short_description' => [
                    'id' => 'Melakukan skrining resep, peracikan obat, konseling pasien, serta monitoring efek samping obat di Instalasi Farmasi Rumah Sakit.',
                    'en' => 'Performing prescription screening, medication counseling, and pharmacy management.',
                ],
                'description' => [
                    'id' => 'Bergabunglah bersama Instalasi Farmasi RSU Fikri Medika untuk memastikan ketepatan dan keselamatan peresepan obat bagi seluruh pasien rawat jalan dan rawat inap.',
                    'en' => 'Join our Pharmacy department to ensure accurate and safe medication delivery.',
                ],
                'requirements' => [
                    'Pendidikan Profesi Apoteker (S.Farm., Apt.) dari universitas terakreditasi',
                    'Memiliki STRA (Surat Tanda Registrasi Apoteker) aktif',
                    'Memahami alur pelayanan farmasi rumah sakit dan regulasi kefarmasian BPOM/Kemenkes',
                    'Teliti, bertanggung jawab, dan memiliki integritas tinggi',
                    'Mampu mengoperasikan sistem informasi manajemen farmasi / SIMRS',
                ],
                'responsibilities' => [
                    'Melakukan telaah dan skrining resep dokter',
                    'Memberikan Pelayanan Informasi Obat (PIO) dan konseling kepada pasien',
                    'Memantau persediaan dan penyimpanan obat high alert / LASA',
                    'Melakukan rekonsiliasi obat pasien rawat inap',
                ],
                'benefits' => [
                    'Gaji Pokok & Tunjangan Jabatan Fungsional',
                    'BPJS Kesehatan & Ketenagakerjaan',
                    'Tunjangan Khusus Profesi Apoteker',
                    'Lingkungan kerja kolaboratif dan modern',
                ],
                'deadline' => now()->addMonths(1)->format('Y-m-d'),
                'status' => 'open',
                'is_featured' => true,
                'is_active' => true,
                'order' => 2,
            ],
            [
                'title' => [
                    'id' => 'Radiografer / Penata Rontgen & CT-Scan',
                    'en' => 'Radiographer / Medical Imaging Technician',
                ],
                'slug' => 'radiografer-penata-rontgen-ct-scan',
                'department' => 'Penunjang Medis',
                'employment_type' => 'Full Time',
                'education_level' => 'D3 / D4 Teknik Radiodiagnostik & Radioterapi',
                'experience_years' => 'Fresh Graduate / 1 Tahun',
                'location' => 'Instalasi Radiologi RSU Fikri Medika',
                'quota' => '2 Orang',
                'short_description' => [
                    'id' => 'Mengoperasikan peralatan radiologi diagnostik termasuk X-Ray digital, Panoramic, dan CT-Scan dengan mengutamakan proteksi radiasi.',
                    'en' => 'Operating medical imaging diagnostic equipment with safety standards.',
                ],
                'description' => [
                    'id' => 'Instalasi Radiologi RSU Fikri Medika dilengkapi alat mutakhir X-Ray Digital dan CT-Scan. Kami mencari radiografer yang siap memberikan pelayanan pencitraan medis berkualitas tinggi.',
                    'en' => 'We are looking for radiographers to deliver high quality imaging services.',
                ],
                'requirements' => [
                    'Pendidikan minimal D3 Teknik Radiologi / Radiodiagnostik (ATRO)',
                    'Memiliki STR Radiografer aktif',
                    'Memahami teknik pemeriksaan X-Ray konvensional/digital dan CT-Scan',
                    'Memahami prinsip ALARA dan keselamatan proteksi radiasi',
                    'Bersedia bekerja dalam shift',
                ],
                'responsibilities' => [
                    'Melakukan pemeriksaan radiologi sesuai permintaan dokter pengirim',
                    'Memastikan kualitas citra radiografi optimal sebelum dibaca dokter radiologi',
                    'Menerapkan protokol proteksi radiasi bagi pasien, staf, dan lingkungan',
                    'Melakukan pemeliharaan harian alat radiologi',
                ],
                'benefits' => [
                    'Gaji Pokok & Tunjangan Bahaya Radiasi',
                    'Pemeriksaan MCU Berkala & Pemantauan TLD Badge',
                    'BPJS Kesehatan & Ketenagakerjaan',
                ],
                'deadline' => now()->addWeeks(6)->format('Y-m-d'),
                'status' => 'open',
                'is_featured' => false,
                'is_active' => true,
                'order' => 3,
            ],
            [
                'title' => [
                    'id' => 'Staff IT Programmer & SIMRS Support',
                    'en' => 'IT Hospital System & SIMRS Staff',
                ],
                'slug' => 'staff-it-programmer-simrs-support',
                'department' => 'Administrasi & IT',
                'employment_type' => 'Full Time',
                'education_level' => 'D3 / S1 Teknik Informatika / Sistem Informasi',
                'experience_years' => 'Minimal 1 Tahun',
                'location' => 'Unit EDP / IT RSU Fikri Medika',
                'quota' => '1 Orang',
                'short_description' => [
                    'id' => 'Mengembangkan, memelihara, dan memberikan dukungan teknis untuk Sistem Informasi Manajemen Rumah Sakit (SIMRS) dan integrasi BPJS / SatuSehat.',
                    'en' => 'Developing and maintaining hospital management information systems (SIMRS).',
                ],
                'description' => [
                    'id' => 'Bergabunglah dalam proses digitalisasi rumah sakit modern untuk meningkatkan efisiensi operasional dan kepuasan pelayanan pasien di RSU Fikri Medika.',
                    'en' => 'Join our digital transformation team at RSU Fikri Medika.',
                ],
                'requirements' => [
                    'Pendidikan D3/S1 Teknik Informatika, Ilmu Komputer, atau Sistem Informasi',
                    'Menguasai PHP (Laravel framework), MySQL / PostgreSQL, JavaScript, dan REST API',
                    'Familiar dengan integrasi bridging BPJS Kesehatan (VClaim, PCare) dan Kemenkes SatuSehat menjadi nilai tambah',
                    'Memahami jaringan dasar LAN/WAN, troubleshooting hardware, dan database backup',
                    'Mampu bekerja mandiri maupun dalam tim dengan komunikasi yang baik',
                ],
                'responsibilities' => [
                    'Mengembangkan modul SIMRS dan integrasi sistem layanan rumah sakit',
                    'Melakukan pemeliharaan database, server lokal, dan backup data rutin',
                    'Memberikan technical support cepat tanggap kepada user ruangan dan kasir/pendaftaran',
                    'Memastikan kepatuhan keamanan data rekam medis elektronik',
                ],
                'benefits' => [
                    'Gaji Pokok & Tunjangan IT Kompetensi',
                    'BPJS Kesehatan & Ketenagakerjaan',
                    'Pelatihan Sertifikasi IT & Cloud',
                ],
                'deadline' => now()->addWeeks(4)->format('Y-m-d'),
                'status' => 'open',
                'is_featured' => false,
                'is_active' => true,
                'order' => 4,
            ],
        ];

        foreach ($careers as $item) {
            Career::updateOrCreate(['slug' => $item['slug']], $item);
        }
    }
}
