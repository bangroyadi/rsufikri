<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$article = App\Models\Article::where('slug', 'rekomendasi-dokter-spesialis-penyakit-dalam-sppd-di-karawang-jadwal-praktik-rsu-fikri-medika')->first();

if (!$article) {
    echo "Article not found by exact slug, searching by keyword..." . PHP_EOL;
    $article = App\Models\Article::where('slug', 'like', '%penyakit-dalam%')->first();
}

if ($article) {
    $title = [
        'id' => 'Rekomendasi Dokter Spesialis Penyakit Dalam (Sp.PD) di Karawang & Jadwal Praktik RSU Fikri Medika',
        'en' => 'Recommended Internal Medicine Specialists (Sp.PD) in Karawang & Practice Schedule at RSU Fikri Medika'
    ];

    $excerpt = [
        'id' => 'Mencari dokter spesialis penyakit dalam (Sp.PD) terbaik di Karawang? Simak rekomendasi dokter, jadwal praktik harian, jenis penyakit yang ditangani, dan panduan pendaftaran di RSU Fikri Medika.',
        'en' => 'Looking for the best internal medicine specialist (Sp.PD) in Karawang? Check out doctor recommendations, daily practice schedules, conditions treated, and appointment booking at RSU Fikri Medika.'
    ];

    $contentId = <<<'HTML'
<p class="lead">Kesehatan organ dalam tubuh merupakan fondasi utama bagi vitalitas dan kualitas hidup sehari-hari. Jika Anda atau keluarga mengalami keluhan medis kronis seperti diabetes, hipertensi, gangguan pencernaan, liver, ginjal, atau demam yang tak kunjung sembuh, berkonsultasi dengan <strong>dokter spesialis penyakit dalam (Sp.PD) di Karawang</strong> adalah langkah awal yang sangat penting.</p>

<h2>Apa Itu Dokter Spesialis Penyakit Dalam (Internis)?</h2>
<p>Dokter Spesialis Penyakit Dalam, atau dikenal juga sebagai dokter Internis (Sp.PD), adalah dokter spesialis yang memiliki keahlian mendalam dalam mendiagnosis, mengobati, dan mencegah berbagai penyakit non-bedah yang memengaruhi organ-organ dalam tubuh orang dewasa dan lansia.</p>

<p>Pelayanan <a href="/dokter/penyakit-dalam-karawang" class="text-[#0e7c47] font-bold hover:underline">Poli Spesialis Penyakit Dalam RSU Fikri Medika Karawang</a> mencakup penanganan penyakit metabolik, infeksi tropis, gastrohepatologi (saluran cerna dan hati), ginjal dan hipertensi, endokrin, serta keluhan geriatri.</p>

<h2>Kapan Anda Harus Berkonsultasi ke Dokter Sp.PD?</h2>
<p>Anda disarankan segera menjadwalkan pemeriksaan ke dokter spesialis penyakit dalam bila mengalami salah satu atau beberapa kondisi berikut:</p>
<ul>
    <li><strong>Gejala Diabetes & Gangguan Gula Darah:</strong> Sering merasa haus berlebih, sering buang air kecil di malam hari, penurunan berat badan drastis tanpa sebab, atau luka yang sulit sembuh.</li>
    <li><strong>Hipertensi & Masalah Tekanan Darah:</strong> Tekanan darah tinggi yang memerlukan penyesuaian obat rutin dan pemantauan risiko kardiovaskular.</li>
    <li><strong>Gangguan Saluran Pencernaan & Lambung:</strong> Sakit maag kronis, GERD, nyeri ulu hati hebat, muntah darah, atau gangguan buang air besar yang berkepanjangan.</li>
    <li><strong>Penyakit Hati & Pankreas:</strong> Hepatitis, perlemakan hati (fatty liver), penyakit kuning, atau kenaikan enzim liver (SGOT/SGPT).</li>
    <li><strong>Demam Berkepanjangan & Penyakit Infeksi Tropis:</strong> Demam berdarah dengue (DBD), demam tifoid (tipus), malaria, atau infeksi saluran pernapasan dewasa.</li>
    <li><strong>Kolesterol Tinggi & Asam Urat (Gout):</strong> Sendi bengkak dan nyeri mendadak akibat kristal asam urat atau profil lipid darah yang abnormal.</li>
</ul>

<h2>Rekomendasi Dokter Spesialis Penyakit Dalam di RSU Fikri Medika Karawang</h2>
<p>RSU Fikri Medika Karawang menghadirkan tim dokter spesialis penyakit dalam yang berdedikasi tinggi, berpengalaman, dan ditunjang oleh sarana penunjang medis modern seperti laboratorium klinik 24 jam dan radiologi diagnostik:</p>

<div class="my-6 p-5 rounded-2xl bg-emerald-50/70 border border-emerald-200 space-y-3">
    <h3 class="text-base font-black text-slate-900">1. <a href="/dokter/dr-ahmad-fauzi-sppd" class="text-[#0e7c47] hover:underline">dr. Ahmad Fauzi, Sp.PD</a></h3>
    <p class="text-xs text-slate-700">Dokter Spesialis Penyakit Dalam dengan kompetensi komprehensif dalam diagnosis penyakit organ dalam, penanganan diabetes, hipertensi, dan infeksi tropis dewasa di Karawang.</p>
    <div class="flex items-center gap-2">
        <a href="/dokter/dr-ahmad-fauzi-sppd" class="px-3 py-1.5 rounded-lg bg-[#0e7c47] text-white text-xs font-bold hover:bg-[#096237]">Lihat Profil & Jadwal dr. Ahmad Fauzi</a>
    </div>
</div>

<div class="my-6 p-5 rounded-2xl bg-emerald-50/70 border border-emerald-200 space-y-3">
    <h3 class="text-base font-black text-slate-900">2. <a href="/dokter/dr-h-rahmat-hidayat-sppd-kgeh" class="text-[#0e7c47] hover:underline">dr. H. Rahmat Hidayat, Sp.PD-KGEH</a></h3>
    <p class="text-xs text-slate-700">Konsultan Gastroentero-Hepatologi (Sp.PD-KGEH) yang berfokus pada penanganan penyakit lambung, usus, hati (liver), empedu, pankreas, serta endoskopi saluran cerna.</p>
    <div class="flex items-center gap-2">
        <a href="/dokter/dr-h-rahmat-hidayat-sppd-kgeh" class="px-3 py-1.5 rounded-lg bg-[#0e7c47] text-white text-xs font-bold hover:bg-[#096237]">Lihat Profil & Jadwal dr. Rahmat Hidayat</a>
    </div>
</div>

<h2>Jadwal Praktik Dokter & Cara Pendaftaran di RSU Fikri Medika</h2>
<p>Pemeriksaan rawat jalan dokter spesialis penyakit dalam di RSU Fikri Medika berlangsung setiap hari kerja sesuai jadwal poliklinik. Anda dapat melihat jadwal terkini seluruh dokter di halaman <a href="/jadwal-dokter?spesialis=penyakit-dalam" class="text-[#0e7c47] font-bold hover:underline">Jadwal Dokter RSU Fikri Medika</a> atau melihat seluruh daftar spesialis pada direktori <a href="/dokter-di-karawang" class="text-[#0e7c47] font-bold hover:underline">Dokter di Karawang</a>.</p>

<p>Untuk kemudahan Anda dan menghindari antrean panjang, pendaftaran janji temu dapat dilakukan secara online melalui halaman <a href="/buat-janji" class="text-[#0e7c47] font-bold hover:underline">Pendaftaran / Buat Janji Online</a> atau melalui WhatsApp Customer Service RSU Fikri Medika Karawang.</p>
HTML;

    $content = [
        'id' => $contentId,
        'en' => $contentId
    ];

    $article->update([
        'title' => $title,
        'excerpt' => $excerpt,
        'content' => $content
    ]);

    // Link doctor relationships
    $spPdDoctors = App\Models\Doctor::whereHas('polyclinic', fn($q) => $q->where('slug', 'penyakit-dalam'))->pluck('id');
    $article->doctors()->sync($spPdDoctors);

    echo "Successfully updated Article ID {$article->id} with enriched Doctor SEO Cluster content!" . PHP_EOL;
}
