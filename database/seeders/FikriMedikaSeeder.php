<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\HospitalProfile;
use App\Models\Banner;
use App\Models\Polyclinic;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Service;
use App\Models\News;
use App\Models\Article;
use App\Models\Gallery;

class FikriMedikaSeeder extends Seeder
{
    public function run(): void
    {
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();

        // 1. Create Admin User
        $admin = User::updateOrCreate(
            ['email' => 'admin@rsufikrimedika.com'],
            [
                'name' => 'Administrator RSU Fikri Medika',
                'password' => Hash::make('password'),
                'role' => 'superadmin',
                'is_active' => true,
            ]
        );

        // 2. Create Hospital Profile
        HospitalProfile::truncate();
        HospitalProfile::create([
            'name' => 'RSU Fikri Medika',
            'logo' => null,
            'address' => 'Jl. Raya Kosambi - Telagasari No. 9, Klari, Kabupaten Karawang, Jawa Barat 41371',
            'phone' => '(0267) 8454123',
            'whatsapp' => '0812-3456-7890',
            'email' => 'info@rsufikrimedika.com',
            'emergency_phone' => '(0267) 8454999',
            'maps_embed' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.5132717070197!2d107.36952737503886!3d-6.327471993662121!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6975a5cb3333cd%3A0x2aa7847b3117498c!2sRSU%20Fikri%20Medika!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid" width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
            'operating_hours' => '24 Jam / 7 Hari',
            'social_links' => [
                'facebook' => 'https://facebook.com/rsufikrimedika',
                'instagram' => 'https://instagram.com/rsufikrimedika',
                'youtube' => 'https://youtube.com/rsufikrimedika',
            ],
            'about' => [
                'id' => 'RSU Fikri Medika adalah rumah sakit umum terkemuka di Karawang yang memberikan pelayanan kesehatan komprehensif, modern, dan profesional dengan mengedepankan nilai-nilai keramahan Islami. Kami berkomitmen untuk selalu hadir memberikan solusi kesehatan terbaik bagi Anda dan keluarga melalui dukungan tenaga medis spesialis terpercaya dan peralatan medis berteknologi terkini.',
                'en' => 'RSU Fikri Medika is a leading general hospital in Karawang offering comprehensive, modern, and professional healthcare services infused with Islamic warmth and hospitality. We are committed to providing the best healthcare solutions for you and your family through trusted specialist medical teams and state-of-the-art technology.'
            ],
            'vision' => [
                'id' => 'Menjadi Rumah Sakit Umum Terpercaya, Modern, dan Berkarakter Islami dengan Pelayanan Berkualitas Unggul di Jawa Barat.',
                'en' => 'To become a Trusted, Modern, and Islamic-Character General Hospital with Superior Service Quality in West Java.'
            ],
            'mission' => [
                'id' => "1. Memberikan pelayanan kesehatan yang cepat, tepat, aman, dan terjangkau.\n2. Mengintegrasikan kemajuan teknologi medis dengan sentuhan nilai Islami dan empati humanis.\n3. Meningkatkan kompetensi dan profesionalisme seluruh sumber daya manusia kesehatan.\n4. Menyediakan sarana dan prasarana medis modern serta lingkungan rumah sakit yang bersih dan nyaman.",
                'en' => "1. Provide fast, accurate, safe, and affordable health services.\n2. Integrate medical technology advancements with Islamic warmth and humanistic empathy.\n3. Continuous enhancement of competence and professionalism for all healthcare staff.\n4. Supply modern medical equipment and maintain a clean, comfortable hospital environment."
            ],
            'values' => [
                'id' => 'Professional • Islami • Caring • Integrity • Modern',
                'en' => 'Professional • Islamic • Caring • Integrity • Modern'
            ],
        ]);

        // 3. Banners
        Banner::truncate();
        Banner::create([
            'title' => [
                'id' => 'Program Unggulan Kemilau Cinta',
                'en' => 'Kemilau Cinta Featured Program'
            ],
            'subtitle' => [
                'id' => 'Pelayanan persalinan dan kesehatan ibu & anak secara komprehensif, aman, dan penuh kasih dengan sentuhan pelayanan kedokteran Islami & modern.',
                'en' => 'Comprehensive, safe, and compassionate maternity and child health services with Islamic and modern medical care.'
            ],
            'image' => 'hero-doctor.png',
            'button_text' => [
                'id' => 'Daftar Online',
                'en' => 'Online Registration'
            ],
            'button_link' => '#kontak',
            'order' => 1,
            'is_active' => true,
        ]);

        Banner::create([
            'title' => [
                'id' => 'Instalasi Gawat Darurat (IGD 24 Jam)',
                'en' => '24-Hour Emergency Department (IGD)'
            ],
            'subtitle' => [
                'id' => 'Pelayanan medis penanganan gawat darurat cepat, tanggap, dan terpercaya oleh dokter spesialis dan perawat profesional berpengalaman.',
                'en' => 'Fast, responsive, and trusted emergency medical care by experienced specialists and professional nurses.'
            ],
            'image' => 'banner-igd.png',
            'button_text' => [
                'id' => 'Call Emergency: (0267) 8454999',
                'en' => 'Emergency Call: (0267) 8454999'
            ],
            'button_link' => 'tel:02678454999',
            'order' => 2,
            'is_active' => true,
        ]);

        Banner::create([
            'title' => [
                'id' => 'Layanan Hemodialisa & Penunjang Medik',
                'en' => 'Hemodialysis & Medical Support Services'
            ],
            'subtitle' => [
                'id' => 'Fasilitas cuci darah modern berstandar medis tinggi dengan pendampingan dokter spesialis ginjal dan perawat bersertifikasi.',
                'en' => 'Modern dialysis facilities meeting high medical standards with kidney specialists and certified nurses.'
            ],
            'image' => 'banner-profil.png',
            'button_text' => [
                'id' => 'Konsultasi Layanan',
                'en' => 'Service Consultation'
            ],
            'button_link' => '#layanan',
            'order' => 3,
            'is_active' => true,
        ]);

        // 4. Polyclinics
        Polyclinic::truncate();
        $poliBedahPlastik = Polyclinic::create([
            'name' => ['id' => 'Bedah Plastik', 'en' => 'Plastic Surgery'],
            'slug' => 'bedah-plastik',
            'description' => ['id' => 'Layanan bedah plastik rekonstruksi dan estetika.', 'en' => 'Reconstructive and aesthetic plastic surgery services.'],
            'icon' => 'user-md',
            'is_active' => true,
        ]);

        $poliBedahSaraf = Polyclinic::create([
            'name' => ['id' => 'Bedah Saraf', 'en' => 'Neurosurgery'],
            'slug' => 'bedah-saraf',
            'description' => ['id' => 'Operasi sistem saraf pusat dan otak.', 'en' => 'Central nervous system and brain surgery.'],
            'icon' => 'brain',
            'is_active' => true,
        ]);

        $poliDalam = Polyclinic::create([
            'name' => ['id' => 'Poli Penyakit Dalam', 'en' => 'Internal Medicine Clinic'],
            'slug' => 'poli-penyakit-dalam',
            'description' => ['id' => 'Pelayanan diagnostik dan penanganan medis komprehensif penyakit organ dalam dewasa.', 'en' => 'Comprehensive diagnostic and medical management for adult internal organ diseases.'],
            'icon' => 'stethoscope',
            'is_active' => true,
        ]);

        $poliAnak = Polyclinic::create([
            'name' => ['id' => 'Poli Anak (Pediatri)', 'en' => 'Pediatric Clinic'],
            'slug' => 'poli-anak',
            'description' => ['id' => 'Pelayanan kesehatan anak, tumbuh kembang, imunisasi, dan penanganan penyakit pada anak.', 'en' => 'Child health services, growth monitoring, immunization, and pediatric disease treatment.'],
            'icon' => 'baby',
            'is_active' => true,
        ]);

        $poliObgyn = Polyclinic::create([
            'name' => ['id' => 'Poli Kebidanan & Kandungan', 'en' => 'Obstetrics & Gynecology'],
            'slug' => 'poli-kebidanan-kandungan',
            'description' => ['id' => 'Pemeriksaan kehamilan, USG 4D, persalinan, dan kesehatan reproduksi wanita.', 'en' => 'Pregnancy checkups, 4D ultrasound, delivery, and women healthcare.'],
            'icon' => 'heart-pulse',
            'is_active' => true,
        ]);

        $poliBedah = Polyclinic::create([
            'name' => ['id' => 'Poli Bedah Umum', 'en' => 'General Surgery Clinic'],
            'slug' => 'poli-bedah-umum',
            'description' => ['id' => 'Konsultasi dan tindakan operatif bedah minor maupun mayor secara profesional.', 'en' => 'Consultation and surgical procedures for minor and major surgeries.'],
            'icon' => 'scalpel',
            'is_active' => true,
        ]);

        $poliSaraf = Polyclinic::create([
            'name' => ['id' => 'Poli Saraf (Neurologi)', 'en' => 'Neurology Clinic'],
            'slug' => 'poli-saraf',
            'description' => ['id' => 'Penanganan gangguan saraf, otak, tulang belakang, vertigo, dan stroke.', 'en' => 'Treatment for nerve, brain, spine disorders, vertigo, and stroke care.'],
            'icon' => 'brain',
            'is_active' => true,
        ]);

        $poliJantung = Polyclinic::create([
            'name' => ['id' => 'Poli Jantung & Pembuluh Darah', 'en' => 'Cardiology Clinic'],
            'slug' => 'poli-jantung',
            'description' => ['id' => 'Pemeriksaan kesehatan jantung, EKG, Echocardiography, dan konsultasi kardiovaskular.', 'en' => 'Heart health checks, ECG, Echocardiography, and cardiovascular consultation.'],
            'icon' => 'activity',
            'is_active' => true,
        ]);

        $poliMata = Polyclinic::create([
            'name' => ['id' => 'Poli Mata', 'en' => 'Ophthalmology Clinic'],
            'slug' => 'poli-mata',
            'description' => ['id' => 'Pemeriksaan kesehatan mata dan operasi katarak.', 'en' => 'Eye checkups and cataract surgery.'],
            'icon' => 'eye',
            'is_active' => true,
        ]);

        $poliTHT = Polyclinic::create([
            'name' => ['id' => 'Poli THT-KL', 'en' => 'ENT Clinic'],
            'slug' => 'poli-tht',
            'description' => ['id' => 'Pemeriksaan telinga, hidung, dan tenggorokan.', 'en' => 'Ear, nose, and throat examination.'],
            'icon' => 'deaf',
            'is_active' => true,
        ]);

        // 5. Doctors (15 Doctors for pagination test)
        Doctor::truncate();

        $doctorsData = [
            [
                'name' => 'dr. Laksmi Achyati',
                'title_degree' => 'Sp.BP-RE (K)',
                'polyclinic_id' => $poliBedahPlastik->id,
                'specialty' => ['id' => 'Bedah Plastik Rekonstruksi & Estetika', 'en' => 'Plastic Reconstructive & Aesthetic Surgery'],
                'photo' => 'https://images.unsplash.com/photo-1594824813566-7885a3964477?auto=format&fit=crop&w=400&q=80',
                'schedules' => [
                    ['day' => 'Selasa', 'start_time' => '16:00:00', 'end_time' => '19:00:00'],
                    ['day' => 'Jumat', 'start_time' => '16:00:00', 'end_time' => '19:00:00'],
                ]
            ],
            [
                'name' => 'dr. Firman Muharam',
                'title_degree' => 'Sp.BS',
                'polyclinic_id' => $poliBedahSaraf->id,
                'specialty' => ['id' => 'Spesialis Bedah Saraf', 'en' => 'Neurosurgery Specialist'],
                'photo' => 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=400&q=80',
                'schedules' => [
                    ['day' => 'Senin', 'start_time' => '13:00:00', 'end_time' => '17:00:00'],
                    ['day' => 'Selasa', 'start_time' => '13:00:00', 'end_time' => '17:00:00'],
                    ['day' => 'Rabu', 'start_time' => '13:00:00', 'end_time' => '17:00:00'],
                    ['day' => 'Kamis', 'start_time' => '13:00:00', 'end_time' => '17:00:00'],
                    ['day' => 'Jumat', 'start_time' => '13:00:00', 'end_time' => '17:00:00'],
                    ['day' => 'Sabtu', 'start_time' => '13:00:00', 'end_time' => '17:00:00'],
                ]
            ],
            [
                'name' => 'dr. Ahmad Hidayat',
                'title_degree' => 'Sp.PD',
                'polyclinic_id' => $poliDalam->id,
                'specialty' => ['id' => 'Spesialis Penyakit Dalam', 'en' => 'Internal Medicine Specialist'],
                'photo' => 'https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?auto=format&fit=crop&w=400&q=80',
                'schedules' => [
                    ['day' => 'Senin', 'start_time' => '08:00:00', 'end_time' => '12:00:00'],
                    ['day' => 'Rabu', 'start_time' => '14:00:00', 'end_time' => '18:00:00'],
                    ['day' => 'Jumat', 'start_time' => '08:00:00', 'end_time' => '11:30:00'],
                ]
            ],
            [
                'name' => 'dr. Siti Sarah Nurhaliza',
                'title_degree' => 'M.Kes, Sp.A',
                'polyclinic_id' => $poliAnak->id,
                'specialty' => ['id' => 'Spesialis Anak & Tumbuh Kembang', 'en' => 'Pediatric & Growth Specialist'],
                'photo' => 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=400&q=80',
                'schedules' => [
                    ['day' => 'Selasa', 'start_time' => '09:00:00', 'end_time' => '13:00:00'],
                    ['day' => 'Kamis', 'start_time' => '09:00:00', 'end_time' => '13:00:00'],
                    ['day' => 'Sabtu', 'start_time' => '08:00:00', 'end_time' => '12:00:00'],
                ]
            ],
            [
                'name' => 'dr. Budi Santoso',
                'title_degree' => 'Sp.OG',
                'polyclinic_id' => $poliObgyn->id,
                'specialty' => ['id' => 'Spesialis Kebidanan & Kandungan', 'en' => 'Obstetrician & Gynecologist'],
                'photo' => 'https://images.unsplash.com/photo-1537368910025-700350fe46c7?auto=format&fit=crop&w=400&q=80',
                'schedules' => [
                    ['day' => 'Senin', 'start_time' => '13:00:00', 'end_time' => '17:00:00'],
                    ['day' => 'Rabu', 'start_time' => '09:00:00', 'end_time' => '13:00:00'],
                ]
            ],
            [
                'name' => 'dr. Faisal Rahman',
                'title_degree' => 'Sp.B',
                'polyclinic_id' => $poliBedah->id,
                'specialty' => ['id' => 'Spesialis Bedah Umum', 'en' => 'General Surgery Specialist'],
                'photo' => 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=400&q=80',
                'schedules' => [
                    ['day' => 'Selasa', 'start_time' => '10:00:00', 'end_time' => '14:00:00'],
                    ['day' => 'Kamis', 'start_time' => '14:00:00', 'end_time' => '18:00:00'],
                ]
            ],
            [
                'name' => 'dr. Anisa Putri Utami',
                'title_degree' => 'Sp.N',
                'polyclinic_id' => $poliSaraf->id,
                'specialty' => ['id' => 'Spesialis Saraf (Neurologi)', 'en' => 'Neurologist'],
                'photo' => 'https://images.unsplash.com/photo-1594824813566-7885a3964477?auto=format&fit=crop&w=400&q=80',
                'schedules' => [
                    ['day' => 'Jumat', 'start_time' => '13:30:00', 'end_time' => '16:30:00'],
                    ['day' => 'Sabtu', 'start_time' => '09:00:00', 'end_time' => '12:00:00'],
                ]
            ],
            [
                'name' => 'dr. Hendra Wijaya',
                'title_degree' => 'Sp.JP (K)',
                'polyclinic_id' => $poliJantung->id,
                'specialty' => ['id' => 'Spesialis Jantung & Pembuluh Darah', 'en' => 'Cardiologist'],
                'photo' => 'https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?auto=format&fit=crop&w=400&q=80',
                'schedules' => [
                    ['day' => 'Senin', 'start_time' => '09:00:00', 'end_time' => '13:00:00'],
                    ['day' => 'Rabu', 'start_time' => '09:00:00', 'end_time' => '13:00:00'],
                    ['day' => 'Jumat', 'start_time' => '13:00:00', 'end_time' => '16:00:00'],
                ]
            ],
            [
                'name' => 'dr. Rina Kusumawati',
                'title_degree' => 'Sp.M',
                'polyclinic_id' => $poliMata->id,
                'specialty' => ['id' => 'Spesialis Mata', 'en' => 'Ophthalmologist'],
                'photo' => 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=400&q=80',
                'schedules' => [
                    ['day' => 'Selasa', 'start_time' => '08:00:00', 'end_time' => '12:00:00'],
                    ['day' => 'Kamis', 'start_time' => '08:00:00', 'end_time' => '12:00:00'],
                ]
            ],
            [
                'name' => 'dr. Dedi Supriyadi',
                'title_degree' => 'Sp.THT-KL',
                'polyclinic_id' => $poliTHT->id,
                'specialty' => ['id' => 'Spesialis THT-KL', 'en' => 'ENT Specialist'],
                'photo' => 'https://images.unsplash.com/photo-1537368910025-700350fe46c7?auto=format&fit=crop&w=400&q=80',
                'schedules' => [
                    ['day' => 'Rabu', 'start_time' => '13:00:00', 'end_time' => '17:00:00'],
                    ['day' => 'Sabtu', 'start_time' => '08:00:00', 'end_time' => '12:00:00'],
                ]
            ],
            // Page 2 doctors:
            [
                'name' => 'dr. Maya Kartika',
                'title_degree' => 'Sp.A',
                'polyclinic_id' => $poliAnak->id,
                'specialty' => ['id' => 'Spesialis Anak', 'en' => 'Pediatrician'],
                'photo' => 'https://images.unsplash.com/photo-1594824813566-7885a3964477?auto=format&fit=crop&w=400&q=80',
                'schedules' => [
                    ['day' => 'Senin', 'start_time' => '14:00:00', 'end_time' => '17:00:00'],
                    ['day' => 'Jumat', 'start_time' => '14:00:00', 'end_time' => '17:00:00'],
                ]
            ],
            [
                'name' => 'dr. Rizky Pratama',
                'title_degree' => 'Sp.PD',
                'polyclinic_id' => $poliDalam->id,
                'specialty' => ['id' => 'Spesialis Penyakit Dalam', 'en' => 'Internal Medicine Specialist'],
                'photo' => 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=400&q=80',
                'schedules' => [
                    ['day' => 'Selasa', 'start_time' => '08:00:00', 'end_time' => '12:00:00'],
                    ['day' => 'Kamis', 'start_time' => '13:00:00', 'end_time' => '16:00:00'],
                ]
            ],
            [
                'name' => 'dr. Dewi Anggraini',
                'title_degree' => 'Sp.OG',
                'polyclinic_id' => $poliObgyn->id,
                'specialty' => ['id' => 'Spesialis Kebidanan & Kandungan', 'en' => 'Obstetrician & Gynecologist'],
                'photo' => 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=400&q=80',
                'schedules' => [
                    ['day' => 'Jumat', 'start_time' => '08:00:00', 'end_time' => '11:30:00'],
                    ['day' => 'Sabtu', 'start_time' => '13:00:00', 'end_time' => '16:00:00'],
                ]
            ],
        ];

        DoctorSchedule::truncate();

        foreach ($doctorsData as $dData) {
            $doc = Doctor::create([
                'name' => $dData['name'],
                'title_degree' => $dData['title_degree'],
                'polyclinic_id' => $dData['polyclinic_id'],
                'specialty' => $dData['specialty'],
                'photo' => $dData['photo'],
                'bio' => ['id' => 'Dokter spesialis berpengalaman di RSU Fikri Medika.', 'en' => 'Experienced specialist doctor at RSU Fikri Medika.'],
                'is_active' => true,
            ]);

            foreach ($dData['schedules'] as $sData) {
                DoctorSchedule::create([
                    'doctor_id' => $doc->id,
                    'polyclinic_id' => $dData['polyclinic_id'],
                    'day' => $sData['day'],
                    'start_time' => $sData['start_time'],
                    'end_time' => $sData['end_time'],
                    'status' => 'active',
                    'notes' => ['id' => 'Sesi Praktik Regular', 'en' => 'Regular Practice Session'],
                ]);
            }
        }

        // 7. Services
        Service::truncate();
        Service::create([
            'name' => ['id' => 'Instalasi Gawat Darurat (IGD) 24 Jam', 'en' => '24/7 Emergency Room (ER)'],
            'slug' => 'igd-24-jam',
            'short_description' => ['id' => 'Pelayanan penanganan medis darurat 24 jam penuh didukung tim dokter & perawat siaga.', 'en' => 'Round-the-clock emergency medical response supported by emergency medical team.'],
            'description' => ['id' => 'IGD RSU Fikri Medika siap melayani penanganan gawat darurat medis secara cepat, cermat, dan tepat. Dilengkapi dengan unit ambulans siaga 24 jam dan ruang resusitasi berstandar tinggi.', 'en' => 'RSU Fikri Medika ER is prepared for rapid medical emergency intervention with 24/7 standby ambulance and high-standard resuscitation unit.'],
            'icon' => 'ambulance',
            'image' => 'https://images.unsplash.com/photo-1516549655169-df83a0774514?auto=format&fit=crop&w=600&q=80',
            'is_featured' => true,
            'is_active' => true,
            'order' => 1,
        ]);

        Service::create([
            'name' => ['id' => 'Rawat Jalan (Poliklinik Spesialis)', 'en' => 'Outpatient Specialist Clinic'],
            'slug' => 'rawat-jalan',
            'short_description' => ['id' => 'Konsultasi medis dan pemeriksaan kesehatan oleh dokter-dokter spesialis berpengalaman.', 'en' => 'Medical consultations and health checkups by experienced medical specialists.'],
            'description' => ['id' => 'Layanan rawat jalan mencakup berbagai poliklinik spesialis lengkap dengan fasilitas ruang tunggu yang nyaman dan sistem antrean yang efisien.', 'en' => 'Outpatient care encompasses various specialized clinics with comfortable waiting lounges and efficient queue management.'],
            'icon' => 'user-md',
            'image' => 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&w=600&q=80',
            'is_featured' => true,
            'is_active' => true,
            'order' => 2,
        ]);

        Service::create([
            'name' => ['id' => 'Rawat Inap Nyaman & Higienis', 'en' => 'Comfortable & Hygienic Inpatient Rooms'],
            'slug' => 'rawat-inap',
            'short_description' => ['id' => 'Fasilitas kamar rawat inap dari Kelas VIP hingga Kelas 3 dengan suasana tenang.', 'en' => 'Inpatient room facilities from VIP to Class 3 in a peaceful healing environment.'],
            'description' => ['id' => 'Kamar rawat inap RSU Fikri Medika didesain bersih, asri, dan tenang untuk mempercepat proses pemulihan pasien dengan pemantauan perawat 24 jam.', 'en' => 'RSU Fikri Medika inpatient rooms are designed clean and peaceful to accelerate patient recovery with 24/7 nursing monitoring.'],
            'icon' => 'bed',
            'image' => 'https://images.unsplash.com/photo-1586773860418-d37222d8fce3?auto=format&fit=crop&w=600&q=80',
            'is_featured' => true,
            'is_active' => true,
            'order' => 3,
        ]);

        Service::create([
            'name' => ['id' => 'Medical Check Up (MCU)', 'en' => 'Comprehensive Medical Check Up'],
            'slug' => 'medical-check-up',
            'short_description' => ['id' => 'Paket pemeriksaan kesehatan menyeluruh untuk perorangan maupun karyawan perusahaan.', 'en' => 'Comprehensive health examination packages for individuals and corporate employees.'],
            'description' => ['id' => 'Deteksi dini berbagai kondisi kesehatan melalui paket MCU RSU Fikri Medika yang disesuaikan dengan usia dan kebutuhan medis.', 'en' => 'Early detection of various health conditions through RSU Fikri Medika MCU packages tailored to age and medical needs.'],
            'icon' => 'heartbeat',
            'image' => 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=600&q=80',
            'is_featured' => true,
            'is_active' => true,
            'order' => 4,
        ]);

        Service::create([
            'name' => ['id' => 'Laboratorium Terpadu 24 Jam', 'en' => '24/7 Integrated Laboratory'],
            'slug' => 'laboratorium-24-jam',
            'short_description' => ['id' => 'Pemeriksaan darah, urine, patologi, dan tes medis cepat dan akurat.', 'en' => 'Blood tests, urine checks, pathology, and rapid accurate medical testing.'],
            'description' => ['id' => 'Laboratorium RSU Fikri Medika didukung peralatan otomatisasi modern untuk hasil analisis darah dan diagnostik yang cepat dan presisi.', 'en' => 'RSU Fikri Medika lab uses automated equipment for fast and precise blood analysis.'],
            'icon' => 'flask',
            'image' => 'https://images.unsplash.com/photo-1582719508461-905c673771fd?auto=format&fit=crop&w=600&q=80',
            'is_featured' => true,
            'is_active' => true,
            'order' => 5,
        ]);

        Service::create([
            'name' => ['id' => 'Radiologi & CT Scan', 'en' => 'Radiology & CT Scan Imaging'],
            'slug' => 'radiologi-ct-scan',
            'short_description' => ['id' => 'Layanan pencitraan medis Rontgen X-Ray, USG 4D, dan CT Scan digital.', 'en' => 'Medical imaging services including X-Ray, 4D USG, and digital CT Scan.'],
            'description' => ['id' => 'Fasilitas radiologi canggih membantu penegakan diagnosis dokter secara cepat dan akurat dengan radiasi minimal.', 'en' => 'Advanced radiology facilities assist doctors in fast and accurate diagnosis with minimal radiation.'],
            'icon' => 'x-ray',
            'image' => 'https://images.unsplash.com/photo-1516549655169-df83a0774514?auto=format&fit=crop&w=600&q=80',
            'is_featured' => true,
            'is_active' => true,
            'order' => 6,
        ]);

        // 8. News
        News::truncate();
        News::create([
            'title' => [
                'id' => 'RSU Fikri Medika Mengadakan Bakti Sosial Kesehatan dan Pengobatan Gratis',
                'en' => 'RSU Fikri Medika Holds Free Healthcare Social Service & Medical Camp'
            ],
            'slug' => 'rsu-fikri-medika-mengadakan-bakti-sosial',
            'thumbnail' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=600&q=80',
            'excerpt' => [
                'id' => 'Sebagai wujud kepedulian sosial, RSU Fikri Medika menyelenggarakan layanan kesehatan dan pemeriksaan gratis bagi ratusan warga Klari.',
                'en' => 'As a reflection of social care, RSU Fikri Medika organized free health checkups and treatments for hundreds of Klari residents.'
            ],
            'content' => [
                'id' => '<p>Karawang – RSU Fikri Medika kembali menunjukkan komitmennya dalam menebar kebaikan dan nilai-nilai empati Islami melalui kegiatan Bakti Sosial Kesehatan Gratis pada akhir pekan lalu. Acara yang bertempat di pelataran rumah sakit ini berhasil melayani lebih dari 300 warga masyarakat sekitar.</p><p>Direktur RSU Fikri Medika menyampaikan bahwa kegiatan ini bertujuan untuk meningkatkan kesadaran masyarakat akan pentingnya menjaga kesehatan dan deteksi dini penyakit kronis.</p>',
                'en' => '<p>Karawang – RSU Fikri Medika demonstrated its commitment to Islamic empathy values through a Free Health Social Service event last weekend. Held at the hospital grounds, the event served over 300 local residents.</p><p>The Director of RSU Fikri Medika noted that this initiative aims to raise community awareness on health maintenance and early disease detection.</p>'
            ],
            'category' => ['id' => 'Kegiatan RS', 'en' => 'Hospital Event'],
            'author_id' => $admin->id,
            'is_published' => true,
            'published_at' => now()->subDays(2),
        ]);

        News::create([
            'title' => [
                'id' => 'Peningkatan Fasilitas Laboratorium Baru Berteknologi Otomatisasi Modern',
                'en' => 'Upgrade of New Laboratory Facilities with Automated Technology'
            ],
            'slug' => 'peningkatan-fasilitas-laboratorium-baru',
            'thumbnail' => 'https://images.unsplash.com/photo-1582719508461-905c673771fd?auto=format&fit=crop&w=600&q=80',
            'excerpt' => [
                'id' => 'RSU Fikri Medika meresmikan instalasi alat analisa laboratorium otomatis yang mempercepat hasil tes darah hanya dalam waktu 30 menit.',
                'en' => 'RSU Fikri Medika inaugurated automated laboratory analyzer units delivering blood test results within 30 minutes.'
            ],
            'content' => [
                'id' => '<p>Guna meningkatkan kecepatan dan akurasi pelayanan diagnostik, RSU Fikri Medika kini memperbarui jajaran instrumen laboratorium dengan teknologi otomasi terbaru. Penambahan alat ini memungkinkan dokter menangani pasien darurat dengan keputusan klinis yang lebih cepat.</p>',
                'en' => '<p>To elevate diagnostic speed and accuracy, RSU Fikri Medika upgraded its laboratory instruments with state-of-the-art automation. This allows emergency doctors to make clinical decisions faster.</p>'
            ],
            'category' => ['id' => 'Fasilitas RS', 'en' => 'Hospital Facility'],
            'author_id' => $admin->id,
            'is_published' => true,
            'published_at' => now()->subDays(5),
        ]);

        // 9. Articles
        Article::truncate();
        Article::create([
            'title' => [
                'id' => 'Tips Menjaga Pola Hidup Sehat & Bugar Menurut Medis dan Sunnah',
                'en' => 'Tips for Maintaining a Healthy Lifestyle According to Medicine and Sunnah'
            ],
            'slug' => 'tips-menjaga-pola-hidup-sehat',
            'thumbnail' => 'https://images.unsplash.com/photo-1498837167922-ddd27525d352?auto=format&fit=crop&w=600&q=80',
            'excerpt' => [
                'id' => 'Kombinasi antara nutrisi seimbang, konsumsi air putih cukup, olahraga rutin, serta kebiasaan hidup bersih merupakan kunci tubuh yang bugar.',
                'en' => 'A balance of nutrition, sufficient hydration, regular exercise, and hygienic habits key to a healthy body.'
            ],
            'content' => [
                'id' => '<p>Kesehatan adalah nikmat utama yang patut kita syukuri. Dalam dunia medis modern, pencegahan penyakit (preventif) selalu lebih baik daripada pengobatan (kuratif). Berikut beberapa langkah praktis yang bisa Anda terapkan harian...</p>',
                'en' => '<p>Health is a priceless blessing. In modern medical practice, prevention is always better than cure. Here are practical daily steps to maintain vital health...</p>'
            ],
            'category' => ['id' => 'Edukasi Kesehatan', 'en' => 'Health Education'],
            'author_id' => $admin->id,
            'is_published' => true,
            'published_at' => now()->subDays(3),
        ]);

        Article::create([
            'title' => [
                'id' => 'Pentingnya Deteksi Dini Demam Berdarah (DBD) pada Anak',
                'en' => 'Importance of Early Detection for Dengue Fever in Children'
            ],
            'slug' => 'pentingnya-deteksi-dini-dbd-pada-anak',
            'thumbnail' => 'https://images.unsplash.com/photo-1584515979956-d9f6e5d09982?auto=format&fit=crop&w=600&q=80',
            'excerpt' => [
                'id' => 'Kenali fase pelana kuda pada demam berdarah agar penanganan medis pada anak tidak terlambat.',
                'en' => 'Recognize the critical phase of dengue fever so medical treatment for children is never delayed.'
            ],
            'content' => [
                'id' => '<p>Demam tinggi mendadak selama 2-7 hari pada anak perlu diwaspadai sebagai gejala DBD. Jangan menunggu munculnya bintik merah di kulit, segera lakukan pemeriksaan darah ke laboratorium atau konsultasi ke Poli Anak RSU Fikri Medika.</p>',
                'en' => '<p>Sudden high fever for 2-7 days in children must be monitored closely for Dengue. Do not wait for red spots; seek immediate blood checks or pediatric consultation.</p>'
            ],
            'category' => ['id' => 'Kesehatan Anak', 'en' => 'Pediatric Health'],
            'author_id' => $admin->id,
            'is_published' => true,
            'published_at' => now()->subDays(7),
        ]);

        // 10. Galleries
        Gallery::truncate();
        Gallery::create([
            'title' => ['id' => 'Gedung Utama RSU Fikri Medika', 'en' => 'Main Building RSU Fikri Medika'],
            'description' => ['id' => 'Tampak depan gedung RSU Fikri Medika Klari Karawang.', 'en' => 'Front view of RSU Fikri Medika building in Karawang.'],
            'image' => 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?auto=format&fit=crop&w=600&q=80',
            'category' => ['id' => 'Fasilitas', 'en' => 'Facilities'],
            'is_active' => true,
        ]);
        Gallery::create([
            'title' => ['id' => 'Ruang Rawat Inap VIP', 'en' => 'VIP Inpatient Room'],
            'description' => ['id' => 'Kamar rawat inap nyaman dengan fasilitas lengkap.', 'en' => 'Comfortable inpatient room with full amenities.'],
            'image' => 'https://images.unsplash.com/photo-1586773860418-d37222d8fce3?auto=format&fit=crop&w=600&q=80',
            'category' => ['id' => 'Rawat Inap', 'en' => 'Inpatient'],
            'is_active' => true,
        ]);

        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();
    }
}
