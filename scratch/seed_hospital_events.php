<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\HospitalEvent;

if (HospitalEvent::count() === 0) {
    HospitalEvent::create([
        'title' => [
            'id' => 'Senam Hamil & Screening USG Gratis: Langkah Sehat, Ibu Hebat, Bayi Selamat',
            'en' => 'Prenatal Yoga & Free Ultrasound Screening: Healthy Steps for Mothers and Babies'
        ],
        'slug' => 'senam-hamil-dan-screening-usg-gratis',
        'category' => 'Senam & Edukasi Sehat',
        'event_date' => '2026-09-05',
        'start_time' => '07:30 WIB',
        'end_time' => '11:00 WIB',
        'location' => 'Auditorium & Ruang Senam Hamil RSU Fikri Medika',
        'speakers' => [
            ['name' => 'dr. Rihi Nofiandi, Sp.OG, FICS', 'role' => 'Dokter Spesialis Kebidanan & Kandungan'],
            ['name' => 'Bdn. Siti Rahmawati, S.Tr.Keb', 'role' => 'Instruktur Senam Hamil & Konselor Laktasi']
        ],
        'quota' => '35 Ibu Hamil',
        'price_type' => 'Gratis / Free',
        'price' => 'Gratis',
        'benefits' => [
            'Free Screening USG Kehamilan',
            'Buku KIA & Panduan Nutrisi Ibu Hamil',
            'Healthy Snack Box & Minuman Nutrisi',
            'Konsultasi Langsung dengan Dokter Sp.OG',
            'Voucher Diskon Persalinan Kemilau Cinta'
        ],
        'image' => 'gedung1_web.jpg',
        'short_description' => [
            'id' => 'Wujudkan kehamilan yang sehat, nyaman, dan penuh keyakinan sejak dini bersama tim dokter spesialis obgyn dan bidan profesional RSU Fikri Medika.',
            'en' => 'Empower your pregnancy journey with prenatal yoga and ultrasound screening by our expert OBGYN team.'
        ],
        'description' => [
            'id' => "Program edukasi dan senam hamil terpadu persembahan RSU Fikri Medika untuk membantu calon ibu mempersiapkan fisik dan mental menjelang persalinan.\n\nAgenda Kegiatan:\n1. 07:30 - 08:00 : Registrasi & Pemeriksaan Tanda Vital (Tekanan Darah & HB)\n2. 08:00 - 09:00 : Sesi Senam Hamil & Relaksasi Pernapasan\n3. 09:00 - 10:00 : Talkshow Interaktif 'Tanda Bahaya Kehamilan & Kesiapan Persalinan' oleh dr. Rihi Nofiandi, Sp.OG\n4. 10:00 - 11:00 : Sesi Screening USG & Pembagian Goodie Bag",
            'en' => "Comprehensive prenatal exercise and educational workshop by RSU Fikri Medika."
        ],
        'registration_link' => 'https://wa.me/6289678211575?text=Halo%20RSU%20Fikri%20Medika,%20saya%20ingin%20mendaftar%20Event%20Senam%20Hamil',
        'whatsapp_contact' => '089678211575',
        'status' => 'upcoming',
        'is_featured' => true,
        'is_active' => true,
        'order' => 1,
    ]);

    HospitalEvent::create([
        'title' => [
            'id' => 'Simposium Medis: Deteksi Dini & Tatalaksana Komprehensif Penyakit Jantung Koroner',
            'en' => 'Medical Symposium: Early Detection & Management of Coronary Artery Disease'
        ],
        'slug' => 'simposium-medis-penyakit-jantung-koroner',
        'category' => 'Seminar & Webinar',
        'event_date' => '2026-09-19',
        'start_time' => '08:30 WIB',
        'end_time' => '12:30 WIB',
        'location' => 'Auditorium Utama RSU Fikri Medika & Live Zoom Streaming',
        'speakers' => [
            ['name' => 'dr. H. Fikri, Sp.JP, FIHA', 'role' => 'Dokter Spesialis Jantung & Pembuluh Darah'],
            ['name' => 'dr. Ahmad Fauzi, Sp.PD-KKV', 'role' => 'Dokter Spesialis Penyakit Dalam']
        ],
        'quota' => '150 Peserta (Hybrid)',
        'price_type' => 'Gratis / Free',
        'price' => 'Gratis',
        'benefits' => [
            'Sertifikat Resmi SKP Kemenkes',
            'Modul Digital Materi & Rekaman Video',
            'Lunch Box & Coffee Break (Peserta Onsite)',
            'Free Pemeriksaan EKG Jantung untuk 25 Pendaftar Pertama'
        ],
        'image' => 'gedung2_web.jpg',
        'short_description' => [
            'id' => 'Tingkatkan pemahaman mengenai faktor risiko serangan jantung, penanganan kegawatdaruratan di rumah, serta teknologi diagnostik jantung terkini.',
            'en' => 'Expand knowledge on coronary artery disease prevention and modern cardiac diagnostic technologies.'
        ],
        'description' => [
            'id' => "Simposium ilmiah medis yang menghadirkan pakar kardiologi terkemuka RSU Fikri Medika untuk membahas tren penanganan penyakit kardiovaskular.\n\nTopik Utama:\n- Patofisiologi & Gejala Tersembunyi Serangan Jantung\n- Algoritma Pertolongan Pertama Henti Jantung (Golden Hour)\n- Pemeriksaan Non-Invasif: Treadmill Test, Echocardiography, dan CT Cardiac",
            'en' => "Scientific symposium on cardiovascular health presented by cardiac specialists."
        ],
        'registration_link' => 'https://wa.me/6289678211575?text=Halo%20RSU%20Fikri%20Medika,%20saya%20ingin%20mendaftar%20Simposium%20Jantung',
        'whatsapp_contact' => '089678211575',
        'status' => 'upcoming',
        'is_featured' => true,
        'is_active' => true,
        'order' => 2,
    ]);

    HospitalEvent::create([
        'title' => [
            'id' => 'Bakti Sosial & Donor Darah Massal HUT RSU Fikri Medika: Setetes Darah Sejuta Harapan',
            'en' => 'Charity Blood Donation Drive: A Drop of Blood, A Million Hopes'
        ],
        'slug' => 'bakti-sosial-dan-donor-darah-massal',
        'category' => 'Bakti Sosial & Donor Darah',
        'event_date' => '2026-09-26',
        'start_time' => '08:00 WIB',
        'end_time' => '13:00 WIB',
        'location' => 'Lobby Gedung Utama RSU Fikri Medika (Kerjasama PMI Karawang)',
        'speakers' => [
            ['name' => 'Tim Medis & Konselor Transfusi PMI Karawang', 'role' => 'Unit Transfusi Darah']
        ],
        'quota' => '200 Kantong Darah',
        'price_type' => 'Gratis / Terbuka untuk Umum',
        'price' => 'Gratis',
        'benefits' => [
            'Paket Sembako & Makanan Bergizi',
            'Pemeriksaan Hemoglobin, Tekanan Darah & Golongan Darah Gratis',
            'Konsultasi Kesehatan Dokter Umum Gratis',
            'Souvenir Eksklusif HUT RSU Fikri Medika'
        ],
        'image' => 'gedung1_web.jpg',
        'short_description' => [
            'id' => 'Aksi nyata kemanusiaan untuk membantu ketersediaan darah bagi pasien darurat dan operasi medis di wilayah Karawang dan sekitarnya.',
            'en' => 'Community blood drive in partnership with Indonesian Red Cross (PMI).'
        ],
        'description' => [
            'id' => "Dalam rangka menyemarakkan HUT RSU Fikri Medika, kami mengajak seluruh masyarakat dan keluarga besar pasien untuk berpartisipasi dalam aksi donor darah massal.",
            'en' => "Annual blood donation charity drive organized by RSU Fikri Medika."
        ],
        'registration_link' => 'https://wa.me/6289678211575?text=Halo%20RSU%20Fikri%20Medika,%20saya%20ingin%20mendaftar%20Donor%20Darah',
        'whatsapp_contact' => '089678211575',
        'status' => 'upcoming',
        'is_featured' => false,
        'is_active' => true,
        'order' => 3,
    ]);

    HospitalEvent::create([
        'title' => [
            'id' => 'Workshop Basic Life Support (BLS) & Penanganan Kegawatdaruratan Medis Sehari-hari',
            'en' => 'Basic Life Support (BLS) & Medical Emergency Response Workshop'
        ],
        'slug' => 'workshop-basic-life-support-emergency',
        'category' => 'Workshop Medis',
        'event_date' => '2026-10-10',
        'start_time' => '08:30 WIB',
        'end_time' => '15:30 WIB',
        'location' => 'Pusat Pelatihan & Simulasi Medis RSU Fikri Medika',
        'speakers' => [
            ['name' => 'dr. Sarah Amalia, Sp.An-TI', 'role' => 'Dokter Spesialis Anestesi & Terapi Intensif'],
            ['name' => 'Ns. Hendra Wijaya, S.Kep', 'role' => 'Instruktur Resusitasi Jantung Paru (RJP)']
        ],
        'quota' => '40 Peserta',
        'price_type' => 'Gratis / Free',
        'price' => 'Gratis',
        'benefits' => [
            'Sertifikat Pelatihan BLS RSU Fikri Medika',
            'Hands-on Training dengan Manekin Simulasi Modern',
            'Handbook Penanganan Gawat Darurat',
            'Lunch Box & 2x Coffee Break'
        ],
        'image' => 'gedung2_web.jpg',
        'short_description' => [
            'id' => 'Pelatihan keterampilan dasar bantuan hidup untuk masyarakat umum, tim K3 perusahaan, dan relawan kesehatan dalam menghadapi situasi henti jantung dan tersedak.',
            'en' => 'Essential CPR and first-aid life saving skills training with modern simulation mannequins.'
        ],
        'description' => [
            'id' => "Keterampilan menyelamatkan nyawa adalah hal krusial. Workshop ini membekali peserta dengan teknik RJP (Resusitasi Jantung Paru), penggunaan defibrilator otomatis (AED), serta penanganan tersedak pada dewasa dan bayi.",
            'en' => "Life-saving CPR and AED hands-on training workshop."
        ],
        'registration_link' => 'https://wa.me/6289678211575?text=Halo%20RSU%20Fikri%20Medika,%20saya%20ingin%20mendaftar%20Workshop%20BLS',
        'whatsapp_contact' => '089678211575',
        'status' => 'upcoming',
        'is_featured' => false,
        'is_active' => true,
        'order' => 4,
    ]);

    echo "Successfully seeded " . HospitalEvent::count() . " hospital events!" . PHP_EOL;
} else {
    echo "Hospital events already exist (" . HospitalEvent::count() . " items)." . PHP_EOL;
}
