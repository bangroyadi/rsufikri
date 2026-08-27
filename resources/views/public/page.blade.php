@extends('layouts.app')

@section('content')

@php
    $galleryImages = isset($service) ? $service->gallery_images : [];
    $serviceImg = isset($service) && !empty($service->image)
        ? (\Illuminate\Support\Str::startsWith($service->image, ['http://', 'https://']) ? $service->image : asset($service->image))
        : null;

    $currentSlug = $slug ?? (isset($service) ? $service->slug : 'layanan');

    // ═══════════════════════════════════════════════════════════════
    // SERVICE DATA CONFIGURATION (IGD 24 JAM STYLE TEMPLATE)
    // ═══════════════════════════════════════════════════════════════
    $serviceConfigs = [
        'rawat-inap' => [
            'badge' => 'Pelayanan Rawat Inap',
            'icon' => 'fa-bed-pulse',
            'subtitle' => 'Instalasi Rawat Inap Nyaman & Higienis',
            'about_p1' => 'Instalasi Rawat Inap RSU Fikri Medika Karawang menyediakan fasilitas perawatan rawat inap yang mengutamakan kenyamanan, kebersihan, ketenangan, dan keselamatan pasien (patient safety). Suasana ruangan didesain asri dan ramah untuk menunjang percepatan proses pemulihan kesehatan Anda dan keluarga.',
            'about_p2' => 'Didukung oleh tim perawat profesional 24 jam, dokter penanggung jawab pelayanan (DPJP) yang melakukan visite harian, sistem pemantauan tanda vital terkoneksi, serta pengawasan gizi klinis khusus dari Instalasi Gizi.',
            'facilities_title' => 'Fasilitas & Sarana Kamar Rawat Inap',
            'facilities' => [
                ['icon' => 'fa-crown', 'title' => 'Kamar VVIP & VIP', 'desc' => 'Ruang privat eksklusif dengan AC, TV LED, Smart Bed elektrik, kulkas, sofa bed penunggu, dan kamar mandi dalam mewah.'],
                ['icon' => 'fa-bed', 'title' => 'Kamar Kelas 1 & Kelas 2', 'desc' => 'Kamar berkapasitas 2-3 bed berpendingin udara (AC), TV, tirai sekat medis kedap, dan lingkungan tenang.'],
                ['icon' => 'fa-hospital-user', 'title' => 'Kamar Kelas 3 Standar KRIS', 'desc' => 'Kamar rawat inap higienis dengan sirkulasi udara optimal sesuai standar Kelas Rawat Inap Standar (KRIS) BPJS.'],
                ['icon' => 'fa-bell', 'title' => 'Nurse Call Digital 24 Jam', 'desc' => 'Tombol pemanggil perawat otomatis di samping setiap bed dan kamar mandi untuk respon medis cepat.'],
            ],
            'gallery_photos' => [
                ['img' => 'gedung2_web.jpg', 'badge' => 'Ruang Inap', 'title' => 'Kamar VIP Eksklusif'],
                ['img' => 'gedung1_web.jpg', 'badge' => 'Nurse Station', 'title' => 'Pos Perawat 24 Jam'],
                ['img' => 'banner-igd.png', 'badge' => 'Fasilitas', 'title' => 'Kenyamanan Pasien'],
                ['img' => 'antar-jemput.png', 'badge' => 'Ambulans', 'title' => 'Transportasi Medis'],
            ],
            'system_title' => 'Klasifikasi Kamar Rawat Inap RSU Fikri Medika',
            'system_subtitle' => 'Pilihan akomodasi rawat inap sesuai kebutuhan kenyamanan dan jaminan pasien',
            'systems' => [
                ['theme' => 'bg-emerald-50 text-emerald-900 border-emerald-100 dot-bg-emerald-600', 'title' => 'Kelas VVIP & VIP', 'desc' => '1 Pasien per kamar, Smart Bed Electric, TV Kabel, Kulkas, AC, Water Heater, Meja Makan Pasien, dan Ruang Tamu Keluarga.'],
                ['theme' => 'bg-blue-50 text-blue-900 border-blue-100 dot-bg-blue-600', 'title' => 'Kelas 1 & Kelas 2', 'desc' => '2-3 Pasien per kamar, Bed Manual/Semi-Elektrik, AC, TV Bersama, Tirai Penyekat Antibakteri, dan Kamar Mandi Dalam.'],
                ['theme' => 'bg-amber-50 text-amber-900 border-amber-100 dot-bg-amber-600', 'title' => 'Kelas 3 & Isolasi', 'desc' => 'Maksimal 4 Bed KRIS, AC, Sirkulasi Udara Bertekanan Standar Kemenkes, Kamar Mandi Bersih, dan Layanan BPJS Kesehatan 100%.'],
            ],
            'accordions_title' => 'Informasi Penting & Tata Tertib Rawat Inap',
            'accordions_subtitle' => 'Panduan kenyamanan bagi pasien, keluarga penunggu, dan pengunjung',
            'accordions' => [
                ['icon' => 'fa-clock', 'theme' => 'bg-emerald-100 text-[#0e7c47]', 'tag' => 'Jadwal', 'title' => 'Jam Kunjung Pasien', 'desc' => 'Jam besuk siang: 11.00 - 13.00 WIB | Jam besuk sore: 17.00 - 19.00 WIB. Pasien hanya diperkenankan didampingi maksimal 2 orang penunggu demi ketenangan istirahat.'],
                ['icon' => 'fa-utensils', 'theme' => 'bg-blue-100 text-blue-700', 'tag' => 'Nutrisi', 'title' => 'Layanan Makanan & Gizi', 'desc' => 'Menu makanan disiapkan khusus oleh ahli gizi klinis sesuai diet penyakit (rendah garam, diabetes, lambung, pasca bedah) disajikan 3x makanan utama dan 2x snack per hari.'],
                ['icon' => 'fa-user-doctor', 'theme' => 'bg-amber-100 text-amber-700', 'tag' => 'Visite', 'title' => 'Jadwal Visite Dokter', 'desc' => 'Dokter Penanggung Jawab Pelayanan (DPJP) melakukan visite harian antara pukul 07.30 - 13.00 WIB untuk memantau perkembangan klinis dan advis pengobatan.'],
                ['icon' => 'fa-shield-halved', 'theme' => 'bg-purple-100 text-purple-700', 'tag' => 'Keamanan', 'title' => 'Kebersihan & Keamanan', 'desc' => 'Pembersihan kamar dan pergantian linen dilakukan secara berkala 2x sehari. Dilarang merokok di seluruh area rumah sakit demi kesehatan bersama.'],
            ],
        ],

        'rehabilitasi-medik' => [
            'badge' => 'Rehabilitasi & Fisioterapi',
            'icon' => 'fa-person-walking-with-cane',
            'subtitle' => 'Instalasi Rehabilitasi Medik & Terapi Fisik',
            'about_p1' => 'Instalasi Rehabilitasi Medik RSU Fikri Medika Karawang melayani pemulihan fungsi fisik, neuromuskular, dan motorik pasien akibat penyakit kronis, pasca stroke, cedera tulang/otot, maupun pasca operasi dengan metode terapi modern berbasis bukti klinis.',
            'about_p2' => 'Ditangani langsung oleh tim Fisioterapis profesional, kami membantu pasien mengembalikan kemampuan gerak mandiri, meredakan nyeri berkepanjangan, dan meningkatkan kualitas hidup secara bertahap.',
            'facilities_title' => 'Fasilitas & Modalitas Fisioterapi',
            'facilities' => [
                ['icon' => 'fa-bolt', 'title' => 'Elektroterapi & TENS', 'desc' => 'Modalitas stimulasi listrik saraf (TENS) dan interferensial untuk meredakan nyeri kronis serta spasme otot.'],
                ['icon' => 'fa-fire-flame-curved', 'title' => 'Diatermi (MWD / SWD)', 'desc' => 'Pemanasan jaringan dalam (Microwave Diathermy) untuk memperlancar sirkulasi darah dan relaksasi sendi.'],
                ['icon' => 'fa-arrows-up-down', 'title' => 'Traksi Lumbal & Servikal', 'desc' => 'Peralatan dekompresi tulang belakang mekanik untuk penanganan saraf kejepit (HNP) dan nyeri leher.'],
                ['icon' => 'fa-dumbbell', 'title' => 'Gimnasium Latihan Medis', 'desc' => 'Peralatan latihan gerak, parallel bar, sepeda statis, dan bola terapi untuk pemulihan koordinasi motorik.'],
            ],
            'gallery_photos' => [
                ['img' => 'gedung2_web.jpg', 'badge' => 'Fisioterapi', 'title' => 'Ruang Terapi Gerak'],
                ['img' => 'gedung1_web.jpg', 'badge' => 'Alat Medis', 'title' => 'Peralatan TENS & MWD'],
                ['img' => 'banner-igd.png', 'badge' => 'Rehabilitasi', 'title' => 'Konsultasi Fisioterapis'],
                ['img' => 'spesialis-mata.png', 'badge' => 'Fasilitas', 'title' => 'Gimnasium Medis'],
            ],
            'system_title' => 'Cakupan Pelayanan Rehabilitasi Medik',
            'system_subtitle' => 'Program terapi terstruktur yang disesuaikan dengan kondisi medis tiap pasien',
            'systems' => [
                ['theme' => 'bg-emerald-50 text-emerald-900 border-emerald-100 dot-bg-emerald-600', 'title' => 'Fisioterapi Muskuloskeletal', 'desc' => 'Penanganan nyeri pinggang (LBP), radang sendi (osteoarthritis), kaku bahu (frozen shoulder), dan pasca fraktur/patah tulang.'],
                ['theme' => 'bg-blue-50 text-blue-900 border-blue-100 dot-bg-blue-600', 'title' => 'Rehabilitasi Stroke & Saraf', 'desc' => 'Latihan gerak fungsional, stimulasi kelemahan otot separuh tubuh (hemiparese), dan koordinasi keseimbangan pasca stroke.'],
                ['theme' => 'bg-amber-50 text-amber-900 border-amber-100 dot-bg-amber-600', 'title' => 'Fisioterapi Pediatrik & Pernapasan', 'desc' => 'Terapi keterlambatan motorik anak, fisioterapi dada (chest physiotherapy) untuk batuk/lendir anak, dan koreksi postur.'],
            ],
            'accordions_title' => 'Kapan Anda Membutuhkan Fisioterapi?',
            'accordions_subtitle' => 'Klik kondisi di bawah untuk melihat tanda klinis yang perlu segera diterapi',
            'accordions' => [
                ['icon' => 'fa-bone', 'theme' => 'bg-rose-100 text-rose-600', 'tag' => 'Sendi & Tulang', 'title' => 'Nyeri Sendi & Saraf Kejepit', 'desc' => 'Nyeri leher menjalar ke tangan, nyeri punggung bawah (pinggang) saat duduk/berdiri, dan lutut kaku bunyi gemeretak.'],
                ['icon' => 'fa-brain', 'theme' => 'bg-red-100 text-red-600', 'tag' => 'Neurologi', 'title' => 'Pemulihan Pasca Stroke', 'desc' => 'Kelemahan pada tangan/kaki pasca serangan stroke yang membutuhkan stimulasi neuromuskular dini agar tidak kaku permanen.'],
                ['icon' => 'fa-person-falling', 'theme' => 'bg-amber-100 text-amber-700', 'tag' => 'Trauma', 'title' => 'Pasca Operasi Patah Tulang', 'desc' => 'Kekakuan sendi dan atrofi otot pasca pemasangan pen/gips yang memerlukan latihan mobilisasi bertahap.'],
                ['icon' => 'fa-lungs', 'theme' => 'bg-emerald-100 text-[#0e7c47]', 'tag' => 'Respirasi', 'title' => 'Gangguan Saluran Pernapasan', 'desc' => 'Penumpukan dahak berlebih pada pasien asma, PPOK, atau anak-anak dengan batuk pilek yang sulit mengeluarkan lendir.'],
            ],
        ],

        'farmasi-24-jam' => [
            'badge' => 'Instalasi Farmasi 24 Jam',
            'icon' => 'fa-pills',
            'subtitle' => 'Pelayanan Farmasi & Apotek Rumah Sakit Siaga 24 Jam',
            'about_p1' => 'Instalasi Farmasi RSU Fikri Medika Karawang beroperasi 24 jam non-stop melayani kebutuhan peresepan obat bagi pasien rawat jalan, rawat inap, dan gawat darurat (IGD) dengan sistem peracikan higienis dan terstandar BPOM/Kemenkes.',
            'about_p2' => 'Setiap resep melalui tahapan skrining ganda (telaah resep) oleh Apoteker bersertifikat untuk mencegah interaksi obat yang tidak diinginkan dan memastikan dosis yang tepat bagi keselamatan pasien.',
            'facilities_title' => 'Fasilitas & Keunggulan Layanan Farmasi',
            'facilities' => [
                ['icon' => 'fa-clock', 'title' => 'Buka 24 Jam Non-Stop', 'desc' => 'Melayani penebusan obat emergency IGD, obat pulang rawat inap, dan resep rawat jalan sepanjang waktu.'],
                ['icon' => 'fa-shield-check', 'title' => '100% Obat Asli & Terverifikasi', 'desc' => 'Seluruh persediaan obat dipasok langsung dari distributor resmi bersertifikasi CDOB (Cara Distribusi Obat yang Baik).'],
                ['icon' => 'fa-temperature-low', 'title' => 'Penyimpanan Standar Suhu', 'desc' => 'Dilengkapi cold storage dan pemantau suhu otomatis untuk vaksin, insulin, dan obat termolabil.'],
                ['icon' => 'fa-comments-dollar', 'title' => 'Konseling Obat Gratis (PIO)', 'desc' => 'Edukasi cara pakai obat, efek samping, dan aturan minum oleh Apoteker di ruang konseling khusus.'],
            ],
            'gallery_photos' => [
                ['img' => 'gedung1_web.jpg', 'badge' => 'Farmasi 24h', 'title' => 'Loket Penebusan Obat'],
                ['img' => 'gedung2_web.jpg', 'badge' => 'Peracikan', 'title' => 'Ruang Peracikan Steril'],
                ['img' => 'banner-igd.png', 'badge' => 'Gudang Obat', 'title' => 'Penyimpanan Suhu Terkontrol'],
                ['img' => 'spesialis-mata.png', 'badge' => 'Konseling', 'title' => 'Ruang Konsultasi Apoteker'],
            ],
            'system_title' => 'Alur Pelayanan Resep Farmasi RSU Fikri Medika',
            'system_subtitle' => 'Prosedur dispensing obat cepat dan aman bagi seluruh pasien',
            'systems' => [
                ['theme' => 'bg-emerald-50 text-emerald-900 border-emerald-100 dot-bg-emerald-600', 'title' => '1. Penerimaan & Skrining Resep', 'desc' => 'Resep diverifikasi keabsahannya, dicek dosis, interaksi obat, dan kesesuaian riwayat alergi pasien oleh Apoteker.'],
                ['theme' => 'bg-blue-50 text-blue-900 border-blue-100 dot-bg-blue-600', 'title' => '2. Penyiapan & Peracikan', 'desc' => 'Obat disiapkan atau diracik secara higienis menggunakan kemasan bersegel dan etiket penulisan aturan minum yang jelas.'],
                ['theme' => 'bg-amber-50 text-amber-900 border-amber-100 dot-bg-amber-600', 'title' => '3. Penyerahan & Edukasi (PIO)', 'desc' => 'Pemeriksaan akhir (final check) dan penyerahan obat disertai penjelasan aturan pakai kepada pasien atau keluarga.'],
            ],
            'accordions_title' => 'Layanan Khusus Instalasi Farmasi',
            'accordions_subtitle' => 'Klik layanan di bawah untuk informasi detail pengadaan & informasi obat',
            'accordions' => [
                ['icon' => 'fa-file-prescription', 'theme' => 'bg-emerald-100 text-[#0e7c47]', 'tag' => 'BPJS & Kronis', 'title' => 'Obat Program Kronis BPJS (PRB)', 'desc' => 'Melayani peresepan obat penyakit kronis (Diabetes, Hipertensi, Jantung, PPOK) untuk pasien rujuk balik BPJS Kesehatan.'],
                ['icon' => 'fa-baby', 'theme' => 'bg-pink-100 text-pink-600', 'tag' => 'Pediatrik', 'title' => 'Peracikan Puyer & Sirup Anak', 'desc' => 'Peracikan obat puyer dan sirup dosis anak menggunakan alat otomatis tertutup higienis untuk akurasi dosis optimal.'],
                ['icon' => 'fa-triangle-exclamation', 'theme' => 'bg-amber-100 text-amber-700', 'tag' => 'Keamanan', 'title' => 'Manajemen Obat High Alert & LASA', 'desc' => 'Pemberian label khusus warna kontras pada obat berkonsentrasi tinggi untuk mencegah kekeliruan pengambilan.'],
                ['icon' => 'fa-truck-fast', 'theme' => 'bg-blue-100 text-blue-700', 'tag' => 'Efisiensi', 'title' => 'Antrean Resep Terintegrasi SIMRS', 'desc' => 'Sistem e-Prescribing terhubung langsung dari ruang dokter ke instalasi farmasi mempercepat waktu tunggu obat.'],
            ],
        ],

        'penunjang-medis' => [
            'badge' => 'Penunjang Medis Terpadu',
            'icon' => 'fa-microscope',
            'subtitle' => 'Pusat Diagnostik & Penunjang Medis Rumah Sakit',
            'about_p1' => 'Layanan Penunjang Medis RSU Fikri Medika Karawang menghadirkan fasilitas diagnostik modern yang komprehensif untuk mendukung ketepatan penegakan diagnosis dokter dan evaluasi keberhasilan terapi medis pasien.',
            'about_p2' => 'Didukung oleh Instalasi Radiologi Digital 24 Jam, Laboratorium Patologi Klinik, Laboratorium Patologi Anatomi, dan Instalasi Gizi yang terintegrasi secara digital dengan Rekam Medis Elektronik (RME).',
            'facilities_title' => 'Instalasi Penunjang Diagnostik Utama',
            'facilities' => [
                ['icon' => 'fa-x-ray', 'title' => 'Instalasi Radiologi 24 Jam', 'desc' => 'Rontgen Digital X-Ray, Panoramic Gigi, USG 4D HD-Live, dan CT-Scan dengan radiasi minimal.'],
                ['icon' => 'fa-flask-vial', 'title' => 'Laboratorium Klinik 24 Jam', 'desc' => 'Pemeriksaan darah lengkap, profil lemak, fungsi ginjal/hati, tes gula, dan uji serologi cito.'],
                ['icon' => 'fa-vial-circle-check', 'title' => 'Laboratorium Patologi Anatomi', 'desc' => 'Pemeriksaan biopsi jaringan, histopatologi tumor/kanker, FNAB, dan skrining Pap Smear.'],
                ['icon' => 'fa-apple-whole', 'title' => 'Instalasi Gizi & Dietetik', 'desc' => 'Konsultasi gizi klinis, penghitungan kalori pasien diabetes/ginjal, dan pengolahan diet higienis.'],
            ],
            'gallery_photos' => [
                ['img' => 'gedung2_web.jpg', 'badge' => 'Radiologi', 'title' => 'Peralatan X-Ray Digital'],
                ['img' => 'gedung1_web.jpg', 'badge' => 'Laboratorium', 'title' => 'Analisis Sampel Darah'],
                ['img' => 'banner-igd.png', 'badge' => 'Patologi', 'title' => 'Pemeriksaan Biopsi'],
                ['img' => 'spesialis-mata.png', 'badge' => 'Gizi Klinis', 'title' => 'Konsultasi Ahli Gizi'],
            ],
            'system_title' => 'Tiga Pilar Diagnostik Medis Cepat RSU Fikri Medika',
            'system_subtitle' => 'Integrasi penunjang medis untuk respon klinis yang presisi',
            'systems' => [
                ['theme' => 'bg-emerald-50 text-emerald-900 border-emerald-100 dot-bg-emerald-600', 'title' => '1. Radiologi & Imaging Digital', 'desc' => 'Pencitraan radiografi resolusi tinggi dibaca langsung oleh Dokter Spesialis Radiologi (Sp.Rad) dengan hasil cepat.'],
                ['theme' => 'bg-blue-50 text-blue-900 border-blue-100 dot-bg-blue-600', 'title' => '2. Laboratorium Klinik Otomatis', 'desc' => 'Instrumen auto-analyzer terkalibrasi harian melayani pemeriksaan laboratorium rutin dan emergency cito.'],
                ['theme' => 'bg-amber-50 text-amber-900 border-amber-100 dot-bg-amber-600', 'title' => '3. Patologi Anatomi Spesialistik', 'desc' => 'Penegakan diagnosis pasti keganasan tumor/jaringan oleh Dokter Spesialis Patologi Anatomi (Sp.PA).'],
            ],
            'accordions_title' => 'Keunggulan Penunjang Medis Kami',
            'accordions_subtitle' => 'Klik poin di bawah untuk mengetahui standar mutu pelayanan penunjang',
            'accordions' => [
                ['icon' => 'fa-certificate', 'theme' => 'bg-emerald-100 text-[#0e7c47]', 'tag' => 'Kualitas', 'title' => 'Pemantauan Mutu Berkala (PME/PMI)', 'desc' => 'Laboratorium dan radiologi mengikuti program Pemantapan Mutu Eksternal dan Internal nasional secara berkala.'],
                ['icon' => 'fa-laptop-medical', 'theme' => 'bg-blue-100 text-blue-700', 'tag' => 'Digital', 'title' => 'Bridging Rekam Medis Elektronik', 'desc' => 'Hasil laboratorium dan foto rontgen langsung terhubung ke komputer dokter pemeriksa tanpa menunggu berkas fisik.'],
                ['icon' => 'fa-bolt', 'theme' => 'bg-amber-100 text-amber-700', 'tag' => 'Cito 24 Jam', 'title' => 'Respon Cepat Pasien Emergency', 'desc' => 'Pemeriksaan darah cito dan rontgen trauma IGD selesai dalam hitungan menit untuk tindakan medis darurat.'],
                ['icon' => 'fa-id-card', 'theme' => 'bg-purple-100 text-purple-700', 'tag' => 'Penjaminan', 'title' => 'Menerima BPJS & Asuransi Swasta', 'desc' => 'Seluruh pemeriksaan penunjang medis dapat dijamin oleh BPJS Kesehatan, BPJS Ketenagakerjaan, dan Asuransi Swasta.'],
            ],
        ],

        'radiologi-24-jam' => [
            'badge' => 'Instalasi Radiologi 24 Jam',
            'icon' => 'fa-x-ray',
            'subtitle' => 'Pusat Pencitraan Diagnostik Medis Digital (X-Ray & CT Scan)',
            'about_p1' => 'Instalasi Radiologi RSU Fikri Medika Karawang beroperasi 24 jam melayani pemeriksaan radiografi digital dengan teknologi mutakhir untuk memberikan gambaran anatomi organ tubuh yang jelas dan akurat.',
            'about_p2' => 'Menerapkan protokol keselamatan radiasi internasional (prinsip ALARA) dengan proteksi timbal terbaik sehingga aman bagi pasien dewasa maupun anak-anak. Seluruh ekspertise dibaca langsung oleh Dokter Spesialis Radiologi.',
            'facilities_title' => 'Fasilitas & Modalitas Radiologi',
            'facilities' => [
                ['icon' => 'fa-x-ray', 'title' => 'Rontgen Digital X-Ray (DR)', 'desc' => 'Pencitraan foto rontgen dada (Thorax), tulang, perut, dan ekstremitas dengan detail gambar tajam.'],
                ['icon' => 'fa-tooth', 'title' => 'Panoramic & Dental X-Ray', 'desc' => 'Pencitraan radiografi lengkung gigi rahang atas-bawah untuk persiapan tindakan dokter gigi & bedah mulut.'],
                ['icon' => 'fa-wave-square', 'title' => 'USG 4D HD-Live', 'desc' => 'Ultrasonografi 4 dimensi resolusi tinggi untuk pemantauan kehamilan janin, perut, dan organ urologi.'],
                ['icon' => 'fa-circle-notch', 'title' => 'CT-Scan Digital', 'desc' => 'Pencitraan tomografi komputer resolusi tinggi untuk mendeteksi stroke kepala, pendarahan, dan trauma tubuh.'],
            ],
            'gallery_photos' => [
                ['img' => 'gedung1_web.jpg', 'badge' => 'Digital X-Ray', 'title' => 'Ruang Pemeriksaan Rontgen'],
                ['img' => 'gedung2_web.jpg', 'badge' => 'CT Scan', 'title' => 'Unit CT Scan Digital'],
                ['img' => 'banner-igd.png', 'badge' => 'USG 4D', 'title' => 'Ruang USG Kandungan'],
                ['img' => 'spesialis-mata.png', 'badge' => 'Ekspertise', 'title' => 'Ruang Baca Dokter Radiologi'],
            ],
            'system_title' => 'Jenis Pemeriksaan Radiologi RSU Fikri Medika',
            'system_subtitle' => 'Modalitas lengkap untuk mendiagnosis berbagai gangguan organ tubuh',
            'systems' => [
                ['theme' => 'bg-emerald-50 text-emerald-900 border-emerald-100 dot-bg-emerald-600', 'title' => 'Rontgen Thorax & Tulang', 'desc' => 'Skrining infeksi paru-paru (TBC, pneumonia), pembesaran jantung, dislokasi sendi, dan patah tulang trauma.'],
                ['theme' => 'bg-blue-50 text-blue-900 border-blue-100 dot-bg-blue-600', 'title' => 'Pemeriksaan Khusus & Kontras', 'desc' => 'Pemeriksaan saluran cerna, urografi (BNO-IVP), histerosalpingografi (HSG kebidanan), dan appendikogram.'],
                ['theme' => 'bg-amber-50 text-amber-900 border-amber-100 dot-bg-amber-600', 'title' => 'USG Abdomen & Vaskular', 'desc' => 'Deteksi batu empedu, batu ginjal, pembesaran hati, tumor organ dalam, dan kelainan pembuluh darah Doppler.'],
            ],
            'accordions_title' => 'Panduan Persiapan Pemeriksaan Radiologi',
            'accordions_subtitle' => 'Klik jenis pemeriksaan untuk melihat persiapan yang diperlukan',
            'accordions' => [
                ['icon' => 'fa-person', 'theme' => 'bg-emerald-100 text-[#0e7c47]', 'tag' => 'Rontgen Umum', 'title' => 'Foto Rontgen Tanpa Kontras', 'desc' => 'Tidak memerlukan puasa. Pasien hanya perlu melepas perhiasan logam, ikat pinggang, atau kancing baju sebelum masuk ruang foto.'],
                ['icon' => 'fa-droplet', 'theme' => 'bg-blue-100 text-blue-700', 'tag' => 'Dengan Kontras', 'title' => 'Pemeriksaan Kontras (BNO-IVP/CT-Scan)', 'desc' => 'Wajib melakukan pemeriksaan laboratorium ureum & kreatinin darah terlebih dahulu dan berpuasa 6 jam sebelum tindakan.'],
                ['icon' => 'fa-baby', 'theme' => 'bg-pink-100 text-pink-600', 'tag' => 'USG Kandungan', 'title' => 'Pemeriksaan USG Kandungan & Kandung Kemih', 'desc' => 'Dianjurkan minum air putih 2-3 gelas dan menahan buang air kecil 1 jam sebelum USG agar visualisasi organ lebih jelas.'],
                ['icon' => 'fa-shield-halved', 'theme' => 'bg-purple-100 text-purple-700', 'tag' => 'Proteksi', 'title' => 'Keamanan Pasien Hamil', 'desc' => 'Wajib menginformasikan kepada petugas radiologi apabila Anda sedang hamil atau mencurigai kemungkinan hamil.'],
            ],
        ],

        'laboratorium-klinik' => [
            'badge' => 'Laboratorium Klinik 24 Jam',
            'icon' => 'fa-flask-vial',
            'subtitle' => 'Laboratorium Patologi Klinik Terpadu & Otomatisasi',
            'about_p1' => 'Laboratorium Klinik RSU Fikri Medika Karawang siap 24 jam memberikan pelayanan analisis spesimen darah, urine, cairan tubuh, dan feses dengan mengutamakan akurasi tinggi, kecepatan waktu tunggu hasil (TAT), dan sterilitas pengujian.',
            'about_p2' => 'Dilengkapi alat Auto-Analyzer generasi terkini dan sistem barcode digital sampel untuk meminimalisir risiko tertukarnya spesimen pasien. Melayani pasien rawat jalan, rawat inap, IGD, hingga paket Medical Check Up (MCU).',
            'facilities_title' => 'Fasilitas & Panel Uji Laboratorium',
            'facilities' => [
                ['icon' => 'fa-droplet', 'title' => 'Hematologi Lengkap Otomatis', 'desc' => 'Pemeriksaan Hemoglobin, Leukosit, Trombosit, Hematokrit, Golongan Darah, dan LED.'],
                ['icon' => 'fa-heart-pulse', 'title' => 'Kimia Klinik & Enzim Jantung', 'desc' => 'Profil Gula Darah, Kolesterol Lengkap, Fungsi Hati (SGOT/SGPT), Ginjal (Ureum/Kreatinin), dan Troponin.'],
                ['icon' => 'fa-virus', 'title' => 'Serologi & Imunologi', 'desc' => 'Tes DBD (NS1/IgG/IgM), Tifoid (Widal/Tubex), Hepatitis B & C, HIV, serta pemeriksaan hormon tiroid.'],
                ['icon' => 'fa-vial', 'title' => 'Urinalisis & Mikrobiologi', 'desc' => 'Pemeriksaan urine rutin, tes narkoba 6 parameter, analisa feses, dan kultur resistensi bakteri.'],
            ],
            'gallery_photos' => [
                ['img' => 'gedung2_web.jpg', 'badge' => 'Laboratorium 24h', 'title' => 'Ruang Pengujian Otomatis'],
                ['img' => 'gedung1_web.jpg', 'badge' => 'Flebotomi', 'title' => 'Loket Pengambilan Sampel'],
                ['img' => 'banner-igd.png', 'badge' => 'Auto-Analyzer', 'title' => 'Alat Kimia Darah Canggih'],
                ['img' => 'spesialis-mata.png', 'badge' => 'Mikroskopis', 'title' => 'Pemeriksaan Sel Darah'],
            ],
            'system_title' => 'Paket Pemeriksaan Skrining Laboratorium',
            'system_subtitle' => 'Pilihan panel tes laboratorium berkala untuk deteksi dini kesehatan',
            'systems' => [
                ['theme' => 'bg-emerald-50 text-emerald-900 border-emerald-100 dot-bg-emerald-600', 'title' => 'Panel Demam & Infeksi', 'desc' => 'Pemeriksaan Darah Lengkap, NS1 Dengue, Widal / Tubex Tifoid, dan Urine Rutin untuk mendiagnosa penyebab demam.'],
                ['theme' => 'bg-blue-50 text-blue-900 border-blue-100 dot-bg-blue-600', 'title' => 'Panel Metabolik & Jantung', 'desc' => 'Gula Darah Puasa & 2 Jam PP, HbA1c, Kolesterol Total, HDL, LDL, Trigliserida, Asam Urat, dan Elektrolit Darah.'],
                ['theme' => 'bg-amber-50 text-amber-900 border-amber-100 dot-bg-amber-600', 'title' => 'Panel Pra-Nikah & Kehamilan', 'desc' => 'Golongan Darah & Rhesus, HBsAg, VDRL/TPHA, Anti-HIV, Toxoplasma, Rubella, dan Glukosa Urin Ibu Hamil.'],
            ],
            'accordions_title' => 'Petunjuk Persiapan Pengambilan Sampel',
            'accordions_subtitle' => 'Klik panduan di bawah agar hasil tes laboratorium optimal dan akurat',
            'accordions' => [
                ['icon' => 'fa-utensils', 'theme' => 'bg-emerald-100 text-[#0e7c47]', 'tag' => 'Puasa Medis', 'title' => 'Puasa Pemeriksaan Gula & Lemak', 'desc' => 'Pemeriksaan profil lipid (kolesterol) dan gula darah puasa memerlukan puasa makan selama 10 - 12 jam (tetap boleh minum air putih).'],
                ['icon' => 'fa-vial', 'theme' => 'bg-blue-100 text-blue-700', 'tag' => 'Urine', 'title' => 'Pengambilan Sampel Urine', 'desc' => 'Gunakan urine porsi tengah (midstream urine) di pagi hari ke dalam wadah steril yang disediakan petugas lab.'],
                ['icon' => 'fa-clock', 'theme' => 'bg-amber-100 text-amber-700', 'tag' => 'Hasil Cito', 'title' => 'Waktu Tunggu Hasil Pemeriksaan', 'desc' => 'Pemeriksaan laboratorium rutin selesai dalam 45 - 90 menit. Hasil dapat diakses langsung oleh dokter atau dicetak di loket.'],
                ['icon' => 'fa-syringe', 'theme' => 'bg-purple-100 text-purple-700', 'tag' => 'Flebotomi', 'title' => 'Pengambilan Darah Nyaman', 'desc' => 'Petugas analis laboratorium tersertifikasi menggunakan jarum steril vakum sekali pakai (vacutainer) minim rasa sakit.'],
            ],
        ],

        'laboratorium-patologi' => [
            'badge' => 'Laboratorium Patologi Anatomi',
            'icon' => 'fa-vial-circle-check',
            'subtitle' => 'Pusat Diagnostik Jaringan Tubuh, Biopsi, & Sitologi',
            'about_p1' => 'Laboratorium Patologi Anatomi RSU Fikri Medika Karawang melayani pemeriksaan mikroskopis jaringan tubuh dan cairan seluler untuk menegakkan diagnosis pasti tumor, kanker, infeksi kronis, dan peradangan organ.',
            'about_p2' => 'Ditangani langsung oleh Dokter Spesialis Patologi Anatomi (Sp.PA) dengan fasilitas pemrosesan jaringan otomatis untuk memastikan ketepatan penentuan stadium jaringan jinak vs ganas secara akurat.',
            'facilities_title' => 'Fasilitas & Layanan Patologi Anatomi',
            'facilities' => [
                ['icon' => 'fa-scissors', 'title' => 'Histopatologi Jaringan Biopsi', 'desc' => 'Pemeriksaan jaringan hasil operasi/biopsi kecil (kulit, polip, usus buntu, kista, tiroid, payudara).'],
                ['icon' => 'fa-syringe', 'title' => 'FNAB (Biopsi Jarum Halus)', 'desc' => 'Fine Needle Aspiration Biopsy untuk deteksi benjolan leher, kelenjar getah bening, dan tumor payudara tanpa operasi.'],
                ['icon' => 'fa-venus', 'title' => 'Pap Smear Skrining Serviks', 'desc' => 'Pemeriksaan sitologi leher rahim konvensional dan liquid-based untuk deteksi dini kanker serviks.'],
                ['icon' => 'fa-microscope', 'title' => 'Sitologi Cairan Tubuh', 'desc' => 'Pemeriksaan sel cairan pleura paru, cairan ascites perut, urine sitologi, dan sputum paru.'],
            ],
            'gallery_photos' => [
                ['img' => 'gedung1_web.jpg', 'badge' => 'Patologi Anatomi', 'title' => 'Ruang Preparasi Jaringan'],
                ['img' => 'gedung2_web.jpg', 'badge' => 'Mikroskopis', 'title' => 'Mikroskop Riset Resolusi Tinggi'],
                ['img' => 'banner-igd.png', 'badge' => 'Biopsi', 'title' => 'Pemeriksaan Histopatologi'],
                ['img' => 'spesialis-mata.png', 'badge' => 'Sitologi', 'title' => 'Skrining Pap Smear'],
            ],
            'system_title' => 'Layanan Diagnostik Patologi Anatomi',
            'system_subtitle' => 'Penegakan diagnosis pasti bagi terapi lanjutan dokter spesialis bedah dan onkologi',
            'systems' => [
                ['theme' => 'bg-emerald-50 text-emerald-900 border-emerald-100 dot-bg-emerald-600', 'title' => '1. Histopatologi Bedah & Biopsi', 'desc' => 'Analisis komprehensif jaringan tumor/operasi untuk menentukan jenis tumor jinak atau ganas dan batas sayatan operasi.'],
                ['theme' => 'bg-blue-50 text-blue-900 border-blue-100 dot-bg-blue-600', 'title' => '2. Sitologi Cairan & Pap Smear', 'desc' => 'Deteksi dini perubahan sel pra-kanker pada leher rahim serta analisa sel tumor pada efusi cairan pleura dan ascites.'],
                ['theme' => 'bg-amber-50 text-amber-900 border-amber-100 dot-bg-amber-600', 'title' => '3. Biopsi Aspirasi Jarum Halus (FNAB)', 'desc' => 'Prosedur cepat dan minim nyeri untuk mendiagnosis benjolan tiroid, tumor payudara, dan pembesaran kelenjar getah bening.'],
            ],
            'accordions_title' => 'Informasi Penyerahan Sampel & Hasil Patologi',
            'accordions_subtitle' => 'Klik informasi di bawah untuk alur pengantaran sampel dan waktu hasil',
            'accordions' => [
                ['icon' => 'fa-box-archive', 'theme' => 'bg-emerald-100 text-[#0e7c47]', 'tag' => 'Fiksasi Sampel', 'title' => 'Cairan Fiksatif Formalin 10%', 'desc' => 'Jaringan hasil operasi/biopsi wajib direndam dalam cairan Formalin Buffer 10% segera setelah tindakan untuk mencegah pembusukan sel.'],
                ['icon' => 'fa-clock', 'theme' => 'bg-blue-100 text-blue-700', 'tag' => 'Waktu Hasil', 'title' => 'Waktu Tunggu Ekspertise (3 - 5 Hari Kerja)', 'desc' => 'Pemrosesan histopatologi jaringan memerlukan tahapan fiksasi, pemotongan mikrotom, pewarnaan HE, dan pembacaan dokter spesialis Sp.PA.'],
                ['icon' => 'fa-hospital', 'theme' => 'bg-amber-100 text-amber-700', 'tag' => 'Rujukan Faskes', 'title' => 'Menerima Rujukan Luar Rumah Sakit', 'desc' => 'Menerima sampel jaringan atau blok parafin dari klinik/RS luar dengan melampirkan formulir pengantar dari dokter pengirim.'],
                ['icon' => 'fa-shield-heart', 'theme' => 'bg-purple-100 text-purple-700', 'tag' => 'Akreditasi', 'title' => 'Jaminan Akurasi Diagnosis', 'desc' => 'Hasil patologi anatomi menjadi acuan dasar penentuan protokol terapi kemoterapi, radioterapi, atau pembedahan onkologi.'],
            ],
        ],
    ];

    // Select matched config or fallback default
    $config = $serviceConfigs[$currentSlug] ?? null;

    if (!$config) {
        $config = [
            'badge' => 'Layanan & Fasilitas Rumah Sakit',
            'icon' => 'fa-hospital-user',
            'subtitle' => $title,
            'about_p1' => isset($service) && !empty($service->tr('description'))
                ? $service->tr('description')
                : 'Selamat datang di layanan resmi RSU Fikri Medika Karawang. Kami berkomitmen memberikan pelayanan terbaik, cepat, dan berstandar medis tinggi dengan mengedepankan empati dan nilai-nilai Islami.',
            'about_p2' => isset($service) && !empty($service->tr('short_description'))
                ? $service->tr('short_description')
                : 'Didukung oleh dokter spesialis berpengalaman, perawat profesional, serta fasilitas medis modern 24 jam untuk keluarga Anda.',
            'facilities_title' => 'Keunggulan & Fasilitas ' . $title,
            'facilities' => [
                ['icon' => 'fa-user-doctor', 'title' => 'Tenaga Medis Berpengalaman', 'desc' => 'Dokter spesialis dan tim medis profesional siap memberikan penanganan tepat dan terpercaya.'],
                ['icon' => 'fa-hospital', 'title' => 'Peralatan Canggih & Higienis', 'desc' => 'Didukung fasilitas modern dan lingkungan perawatan yang bersih, aman, dan nyaman.'],
                ['icon' => 'fa-shield-halved', 'title' => 'Penjaminan BPJS & Asuransi', 'desc' => 'Menerima penjaminan BPJS Kesehatan, BPJS Ketenagakerjaan, dan Asuransi Swasta rekanan.'],
                ['icon' => 'fa-heart-pulse', 'title' => 'Pelayanan Terpadu 24 Jam', 'desc' => 'Layanan responsif terintegrasi dengan IGD, Farmasi 24 Jam, dan ambulans siaga.'],
            ],
            'gallery_photos' => [
                ['img' => 'gedung1_web.jpg', 'badge' => 'Fasilitas RS', 'title' => 'Gedung RSU Fikri Medika'],
                ['img' => 'gedung2_web.jpg', 'badge' => 'Pelayanan', 'title' => 'Area Pelayanan Medis'],
                ['img' => 'banner-igd.png', 'badge' => 'Siaga 24h', 'title' => 'Instalasi Gawat Darurat'],
                ['img' => 'spesialis-mata.png', 'badge' => 'Klinik', 'title' => 'Pemeriksaan Spesialistik'],
            ],
            'system_title' => 'Standar Mutu Pelayanan ' . $title,
            'system_subtitle' => 'Komitmen mutu berkelanjutan untuk keselamatan dan kepuasan pasien',
            'systems' => [
                ['theme' => 'bg-emerald-50 text-emerald-900 border-emerald-100 dot-bg-emerald-600', 'title' => '1. Standar Keselamatan Pasien', 'desc' => 'Menerapkan 6 Sasaran Keselamatan Pasien (SKP) Kemenkes RI dalam setiap tahapan pelayanan.'],
                ['theme' => 'bg-blue-50 text-blue-900 border-blue-100 dot-bg-blue-600', 'title' => '2. Digitalisasi Rekam Medis (RME)', 'desc' => 'Sistem informasi rumah sakit terintegrasi satu sehat untuk proses pelayanan cepat dan akurat.'],
                ['theme' => 'bg-amber-50 text-amber-900 border-amber-100 dot-bg-amber-600', 'title' => '3. Pelayanan Ramah & Islami', 'desc' => 'Mengedepankan komunikasi terapeutik, sopan, santun, dan menenteramkan bagi pasien.'],
            ],
            'accordions_title' => 'Informasi Layanan & Konsultasi',
            'accordions_subtitle' => 'Pertanyaan umum seputar prosedur pendaftaran dan pelayanan',
            'accordions' => [
                ['icon' => 'fa-calendar-check', 'theme' => 'bg-emerald-100 text-[#0e7c47]', 'tag' => 'Jadwal', 'title' => 'Jadwal Pelayanan', 'desc' => 'Pelayanan dibuka setiap hari kerja dan siaga 24 jam untuk kasus kegawatdaruratan medis.'],
                ['icon' => 'fa-id-card', 'theme' => 'bg-blue-100 text-blue-700', 'tag' => 'Syarat', 'title' => 'Persyaratan Pendaftaran', 'desc' => 'Membawa KTP / Kartu Keluarga, Kartu BPJS / Asuransi (jika menggunakan penjaminan), dan surat rujukan faskes.'],
                ['icon' => 'fa-phone-volume', 'theme' => 'bg-amber-100 text-amber-700', 'tag' => 'Kontak', 'title' => 'Layanan Informasi & Reservasi', 'desc' => 'Hubungi Call Center RSU Fikri Medika di 0822-8074-9999 atau WhatsApp tim marketing untuk jadwal dokter.'],
                ['icon' => 'fa-shield-halved', 'theme' => 'bg-purple-100 text-purple-700', 'tag' => 'Asuransi', 'title' => 'Kerjasama Asuransi Rekanan', 'desc' => 'Mendukung metode cashless untuk puluhan asuransi kesehatan swasta dan jaminan perusahaan.'],
            ],
        ];
    }
    // Process Dynamic Gallery Images from Admin with fallback to default configuration
    $hasCustomGallery = isset($service) && is_array($service->gallery) && count($service->gallery) > 0;

    if ($hasCustomGallery && !empty($galleryImages) && count($galleryImages) > 0) {
        $displayGallery = array_map(function($url, $idx) use ($title) {
            return [
                'img' => $url,
                'badge' => 'Fasilitas ' . ($idx + 1),
                'title' => $title . ' - Foto ' . ($idx + 1),
            ];
        }, $galleryImages, array_keys($galleryImages));
        $lightboxImages = $galleryImages;
    } else {
        $displayGallery = array_map(function($item) {
            $imgSrc = $item['img'];
            // Fix broken asset fallback if any
            if ($imgSrc === 'antar-jemput.png') {
                $imgSrc = 'gedung2_web.jpg';
            }
            return [
                'img' => asset($imgSrc),
                'badge' => $item['badge'] ?? 'Fasilitas',
                'title' => $item['title'] ?? 'Fasilitas Medis',
            ];
        }, $config['gallery_photos'] ?? []);
        $lightboxImages = array_column($displayGallery, 'img');
    }

    $seoDesc = app(\App\Services\SeoService::class)->sanitizeText($config['about_p1'] ?? (isset($service) ? $service->tr('short_description') : null), 160);
    $pageUrl = url()->current();
@endphp

@section('title', $title . ' | RSU Fikri Medika Karawang')
@section('meta_description', $seoDesc)
@section('canonical_url', $pageUrl)

@section('schema_jsonld')
<script type="application/ld+json">
{!! json_encode(app(\App\Services\SeoService::class)->generateBreadcrumbSchema([
    'Beranda' => url('/'),
    'Layanan' => url('/layanan/rawat-inap'),
    $title => $pageUrl
]), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endsection

<!-- MAIN CONTENT SECTION (WIDE CONTAINER MATCHING IGD 24 JAM) -->
<section class="py-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-10" x-data="servicePageGalleryApp({{ json_encode($lightboxImages) }})">

    <!-- 1. TOP SECTION (TENTANG LAYANAN - MATCHING IGD CARD) -->
    <div class="w-full">
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-sm space-y-6 flex flex-col justify-between border border-gray-100">
            <div class="space-y-6">
                <div class="flex items-center gap-3.5 pb-5 border-b border-gray-100">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-[#0e7c47] flex items-center justify-center text-xl font-extrabold">
                        <i class="fa-solid {{ $config['icon'] }}"></i>
                    </div>
                    <div>
                        <span class="inline-block px-3 py-1 rounded-full bg-emerald-100 text-[#0e7c47] text-xs font-bold mb-1">
                            {{ $config['badge'] }}
                        </span>
                        <h1 class="text-lg sm:text-xl font-bold text-gray-900">{{ $title }}</h1>
                    </div>
                </div>

                <div class="prose max-w-none text-gray-600 leading-relaxed text-xs sm:text-sm space-y-4 font-medium">
                    <p>
                        <strong>{{ $title }} RSU Fikri Medika Karawang</strong> — {{ $config['about_p1'] }}
                    </p>
                    <p>
                        {{ $config['about_p2'] }}
                    </p>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs font-bold text-[#0e7c47]">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>Menerima Pasien BPJS Kesehatan, Asuransi Swasta & Pasien Umum</span>
                </div>
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profile?->whatsapp ?: '089678211575') }}?text={{ urlencode('Halo RSU Fikri Medika, saya ingin konsultasi mengenai: ' . $title) }}"
                   target="_blank"
                   class="inline-flex items-center gap-1.5 text-emerald-800 hover:text-[#0e7c47] hover:underline cursor-pointer">
                    <i class="fa-brands fa-whatsapp text-sm text-[#0e7c47]"></i>
                    <span>Konsultasi Layanan via WhatsApp</span>
                </a>
            </div>
        </div>
    </div>

    <!-- FULL-WIDTH SECTIONS BELOW (EXACT IGD 24H STRUCTURE) -->
    <div class="space-y-10 pt-2">

        <!-- FULL WIDE SECTION 1: FASILITAS & KEUNGGULAN (4-COLS GRID) -->
        <div class="space-y-5">
            <div class="flex items-center gap-2">
                <span class="inline-block px-3 py-1 rounded-full bg-emerald-100 text-[#0e7c47] text-xs font-bold">Fasilitas Utama</span>
                <h3 class="text-xl font-extrabold text-gray-900">{{ $config['facilities_title'] }}</h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach($config['facilities'] as $fac)
                <div class="bg-white p-6 rounded-3xl shadow-sm space-y-3.5 hover:shadow-md transition-all border border-gray-100/50">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-[#0e7c47] flex items-center justify-center text-xl font-bold">
                        <i class="fa-solid {{ $fac['icon'] }}"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 text-base">{{ $fac['title'] }}</h4>
                    <p class="text-xs text-gray-600 leading-relaxed font-medium">
                        {{ $fac['desc'] }}
                    </p>
                </div>
                @endforeach
            </div>
        </div>

        <!-- FULL WIDE SECTION 2: GALERI FASILITAS (DYNAMIC GRID WITH LIGHTBOX) -->
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-sm space-y-6">
            <div class="flex items-center justify-between gap-3 pb-4 border-b border-gray-100 flex-wrap">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-[#0e7c47] flex items-center justify-center text-lg font-bold">
                        <i class="fa-solid fa-images"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-gray-900 text-lg">Galeri Fasilitas & Sarana {{ $title }}</h3>
                        <p class="text-xs text-gray-500 font-medium">Visualisasi ruangan medis & sarana pelayanan RSU Fikri Medika Karawang</p>
                    </div>
                </div>
                @if(count($displayGallery) > 0)
                <div class="text-xs font-bold text-emerald-800 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-100">
                    <span>{{ count($displayGallery) }} Foto</span>
                </div>
                @endif
            </div>

            <!-- PHOTO GRID -->
            @if(count($displayGallery) > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach($displayGallery as $idx => $gPhoto)
                <div @click="openLightbox({{ $idx }})"
                     class="relative rounded-2xl overflow-hidden shadow-xs group h-56 border border-gray-100 cursor-pointer transition-all duration-300 hover:shadow-md hover:-translate-y-1 bg-slate-900">
                    <img src="{{ $gPhoto['img'] }}" alt="{{ $gPhoto['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent"></div>
                    
                    <!-- ZOOM HOVER ICON -->
                    <div class="absolute inset-0 bg-slate-950/25 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <div class="w-9 h-9 rounded-full bg-white/95 text-slate-800 flex items-center justify-center shadow-md text-sm font-bold">
                            <i class="fa-solid fa-magnifying-glass-plus text-[#0e7c47]"></i>
                        </div>
                    </div>

                    <div class="absolute bottom-3 left-3 right-3 text-white">
                        <span class="text-[10px] font-extrabold px-2 py-0.5 rounded bg-[#0e7c47] uppercase tracking-wider mb-1 inline-block">{{ $gPhoto['badge'] }}</span>
                        <h4 class="text-xs font-bold truncate">{{ $gPhoto['title'] }}</h4>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="p-8 text-center bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                <p class="text-xs text-slate-500 font-medium">Foto galeri belum tersedia untuk layanan ini.</p>
            </div>
            @endif
        </div>

        <!-- FULL WIDE SECTION 3: KLASIFIKASI / ALUR PELAYANAN (3-COLS CARDS) -->
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-sm space-y-6">
            <div class="flex items-center gap-3 pb-4 border-b border-gray-100">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-[#0e7c47] flex items-center justify-center text-lg font-bold">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-gray-900 text-lg">{{ $config['system_title'] }}</h3>
                    <p class="text-xs text-gray-500 font-medium">{{ $config['system_subtitle'] }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                @foreach($config['systems'] as $sys)
                @php
                    $dotColor = str_contains($sys['theme'], 'emerald') ? 'bg-emerald-600' : (str_contains($sys['theme'], 'blue') ? 'bg-blue-600' : (str_contains($sys['theme'], 'red') ? 'bg-red-600' : 'bg-amber-500'));
                @endphp
                <div class="p-5 rounded-2xl {{ $sys['theme'] }} space-y-2 border">
                    <div class="flex items-center gap-2">
                        <span class="w-3.5 h-3.5 rounded-full {{ $dotColor }}"></span>
                        <h4 class="font-extrabold text-sm">{{ $sys['title'] }}</h4>
                    </div>
                    <p class="text-xs leading-relaxed font-medium">
                        {{ $sys['desc'] }}
                    </p>
                </div>
                @endforeach
            </div>
        </div>

        <!-- FULL WIDE SECTION 4: INFORMASI & ACCORDION CARDS (4-COLS ACCORDION) -->
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-sm space-y-6" x-data="{ activeCard: null }">
            <div class="flex items-center gap-3 pb-4 border-b border-gray-100">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-[#0e7c47] flex items-center justify-center text-lg font-bold">
                    <i class="fa-solid fa-circle-question"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-gray-900 text-lg">{{ $config['accordions_title'] }}</h3>
                    <p class="text-xs text-gray-500 font-medium">{{ $config['accordions_subtitle'] }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($config['accordions'] as $accIdx => $acc)
                <div class="bg-slate-50/80 hover:bg-slate-100/90 rounded-2xl p-4 shadow-sm hover:shadow-md transition-all cursor-pointer overflow-hidden space-y-2"
                     @click="activeCard = (activeCard === {{ $accIdx }} ? null : {{ $accIdx }})">
                    <div class="flex items-center justify-between gap-2">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full {{ $acc['theme'] }} flex items-center justify-center text-base font-bold shrink-0">
                                <i class="fa-solid {{ $acc['icon'] }}"></i>
                            </div>
                            <div>
                                <h4 class="font-extrabold text-gray-900 text-xs leading-tight">{{ $acc['title'] }}</h4>
                                <span class="text-[10px] font-bold text-[#0e7c47] px-2 py-0.5 bg-emerald-50 rounded-full inline-block mt-0.5">{{ $acc['tag'] }}</span>
                            </div>
                        </div>
                        <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300 text-slate-400"
                           :class="activeCard === {{ $accIdx }} ? 'rotate-180 text-[#0e7c47]' : ''"></i>
                    </div>

                    <div x-show="activeCard === {{ $accIdx }}" x-transition class="pt-2 border-t border-slate-200/60 text-[11px] text-gray-600 leading-relaxed font-medium">
                        {{ $acc['desc'] }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- FULL WIDE SECTION 5: KONTAK MARKETING & PENDAFTARAN -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-gray-100 space-y-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-gray-100 pb-5">
                <div>
                    <span class="text-xs font-extrabold text-[#0e7c47] uppercase tracking-wider flex items-center gap-1.5">
                        <i class="fa-solid fa-handshake-angle"></i>
                        <span>Informasi & Konsultasi Pasien</span>
                    </span>
                    <h3 class="text-lg sm:text-xl font-extrabold text-gray-900 mt-1">Layanan Bantuan & Informasi {{ $title }}</h3>
                    <p class="text-xs text-gray-500 font-medium">Hubungi Customer Care & Tim Informasi RSU Fikri Medika Karawang</p>
                </div>
                <a href="{{ route('buat.janji') }}" class="px-5 py-2.5 rounded-xl bg-[#0e7c47] text-white font-bold text-xs hover:bg-[#096237] transition-all flex items-center gap-2 shadow-xs shrink-0 self-start md:self-auto">
                    <i class="fa-solid fa-calendar-plus text-xs"></i>
                    <span>Daftar / Buat Janji Pasien</span>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <a href="https://wa.me/6281316720656?text=Halo%20Ibu%20Ulfah%20(RSU%20Fikri%20Medika),%20saya%20ingin%20konsultasi%20mengenai%20{{ urlencode($title) }}"
                   target="_blank"
                   class="p-4 rounded-2xl bg-slate-50 hover:bg-emerald-50/70 border border-gray-100 hover:border-emerald-200 transition-all duration-200 flex items-center gap-3.5 group">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-[#0e7c47] group-hover:bg-[#0e7c47] group-hover:text-white transition-colors flex items-center justify-center text-base font-bold shrink-0">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <div>
                        <div class="font-bold text-gray-900 text-xs group-hover:text-[#0e7c47] transition-colors">Ibu Ulfah</div>
                        <div class="text-[11px] text-gray-500 font-mono mt-0.5">0813-1672-0656</div>
                    </div>
                </a>

                <a href="https://wa.me/6281384656298?text=Halo%20Ibu%20Ai%20(RSU%20Fikri%20Medika),%20saya%20ingin%20konsultasi%20mengenai%20{{ urlencode($title) }}"
                   target="_blank"
                   class="p-4 rounded-2xl bg-slate-50 hover:bg-emerald-50/70 border border-gray-100 hover:border-emerald-200 transition-all duration-200 flex items-center gap-3.5 group">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-[#0e7c47] group-hover:bg-[#0e7c47] group-hover:text-white transition-colors flex items-center justify-center text-base font-bold shrink-0">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <div>
                        <div class="font-bold text-gray-900 text-xs group-hover:text-[#0e7c47] transition-colors">Ibu Ai</div>
                        <div class="text-[11px] text-gray-500 font-mono mt-0.5">0813-8465-6298</div>
                    </div>
                </a>

                <a href="https://wa.me/628988965646?text=Halo%20Ibu%20Rina%20(RSU%20Fikri%20Medika),%20saya%20ingin%20konsultasi%20mengenai%20{{ urlencode($title) }}"
                   target="_blank"
                   class="p-4 rounded-2xl bg-slate-50 hover:bg-emerald-50/70 border border-gray-100 hover:border-emerald-200 transition-all duration-200 flex items-center gap-3.5 group">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-[#0e7c47] group-hover:bg-[#0e7c47] group-hover:text-white transition-colors flex items-center justify-center text-base font-bold shrink-0">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <div>
                        <div class="font-bold text-gray-900 text-xs group-hover:text-[#0e7c47] transition-colors">Ibu Rina</div>
                        <div class="text-[11px] text-gray-500 font-mono mt-0.5">0898-8965-646</div>
                    </div>
                </a>

                <a href="https://wa.me/6281382895002?text=Halo%20Ibu%20Itje%20(RSU%20Fikri%20Medika),%20saya%20ingin%20konsultasi%20mengenai%20{{ urlencode($title) }}"
                   target="_blank"
                   class="p-4 rounded-2xl bg-slate-50 hover:bg-emerald-50/70 border border-gray-100 hover:border-emerald-200 transition-all duration-200 flex items-center gap-3.5 group">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-[#0e7c47] group-hover:bg-[#0e7c47] group-hover:text-white transition-colors flex items-center justify-center text-base font-bold shrink-0">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <div>
                        <div class="font-bold text-gray-900 text-xs group-hover:text-[#0e7c47] transition-colors">Ibu Itje</div>
                        <div class="text-[11px] text-gray-500 font-mono mt-0.5">0813-8289-5002</div>
                    </div>
                </a>
            </div>
        </div>

    </div>

    {{-- LIGHTBOX MODAL --}}
    <div x-show="lightboxOpen"
         x-cloak
         @keydown.escape.window="closeLightbox()"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 p-4 backdrop-blur-sm"
         style="display: none;">
        <button @click="closeLightbox()"
                class="absolute top-4 right-4 text-white text-3xl hover:text-gray-300 z-50 p-2 cursor-pointer transition">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <button @click="prevImage()"
                class="absolute left-4 top-1/2 -translate-y-1/2 text-white text-2xl hover:text-gray-300 z-50 p-3 bg-white/10 hover:bg-white/20 rounded-full cursor-pointer transition">
            <i class="fa-solid fa-chevron-left"></i>
        </button>
        <button @click="nextImage()"
                class="absolute right-4 top-1/2 -translate-y-1/2 text-white text-2xl hover:text-gray-300 z-50 p-3 bg-white/10 hover:bg-white/20 rounded-full cursor-pointer transition">
            <i class="fa-solid fa-chevron-right"></i>
        </button>
        <div class="relative max-w-5xl max-h-[85vh] flex flex-col items-center justify-center">
            <img :src="images[activeImageIndex]"
                 alt="{{ $title }}"
                 class="max-w-full max-h-[80vh] object-contain rounded-xl shadow-2xl">
            <div class="text-white text-center text-xs mt-3 bg-slate-900/80 px-4 py-1.5 rounded-full border border-white/10">
                <span x-text="activeImageIndex + 1"></span> / <span x-text="images.length"></span>
            </div>
        </div>
    </div>

</section>

<script>
function servicePageGalleryApp(initialImages) {
    return {
        images: initialImages || [],
        lightboxOpen: false,
        activeImageIndex: 0,
        openLightbox(index) {
            this.activeImageIndex = index;
            this.lightboxOpen = true;
            document.body.style.overflow = 'hidden';
        },
        closeLightbox() {
            this.lightboxOpen = false;
            document.body.style.overflow = 'auto';
        },
        nextImage() {
            if (this.images.length > 0) {
                this.activeImageIndex = (this.activeImageIndex + 1) % this.images.length;
            }
        },
        prevImage() {
            if (this.images.length > 0) {
                this.activeImageIndex = (this.activeImageIndex - 1 + this.images.length) % this.images.length;
            }
        }
    }
}
</script>
@endsection
