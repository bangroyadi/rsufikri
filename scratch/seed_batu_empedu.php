<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Article;
use App\Models\User;

$admin = User::first() ?? User::create([
    'name' => 'Tim Medis RSU Fikri Medika',
    'email' => 'admin@fikrimedika.com',
    'password' => bcrypt('password')
]);

// Add / Update Article: Nyeri Menjalar ke Bahu Kanan Bisa Jadi Batu Empedu
Article::updateOrCreate(
    ['slug' => 'nyeri-menjalar-ke-bahu-kanan-bisa-jadi-batu-empedu'],
    [
        'title' => [
            'id' => 'Nyeri Menjalar ke Bahu Kanan, Bisa Jadi Batu Empedu',
            'en' => 'Pain Radiating to the Right Shoulder: Could It Be Gallstones?'
        ],
        'thumbnail' => 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=1200&q=80',
        'excerpt' => [
            'id' => 'Nyeri pada perut kanan atas yang menusuk hingga menjalar ke punggung dan bahu kanan sering kali disalahartikan sebagai sakit maag biasa. Waspadai gejala penyakit batu empedu (kolelitiasis).',
            'en' => 'Sharp pain in the upper right abdomen radiating to the back and right shoulder is often mistaken for gastric distress. Recognize the signs of gallstone disease (cholelithiasis).'
        ],
        'content' => [
            'id' => '<p class="lead">Pernahkah Anda merasakan nyeri mendadak yang menusuk di area perut kanan atas setelah menyantap makanan berlemak, lalu rasa sakit tersebut menjalar hingga ke punggung atau bahu kanan? Jangan anggap remeh keluhan ini, karena bisa jadi Anda sedang mengalami gejala dari <strong>batu empedu (kolelitiasis)</strong>.</p>
            
            <h2>Apa Itu Batu Empedu (Kolelitiasis)?</h2>
            <p>Batu empedu adalah endapan cairan pencernaan yang mengeras dan terbentuk di dalam kantung empedu. Kantung empedu sendiri merupakan organ kecil berbentuk buah pir di sisi kanan perut, tepat di bawah hati. Organ ini menyimpan cairan empedu yang diproduksi oleh hati untuk membantu mencerna lemak.</p>
            <p>Ukuran batu empedu bisa bervariasi, mulai dari sekecil butiran pasir hingga sebesar bola golf. Seseorang bisa memiliki hanya satu batu empedu atau bahkan ratusan batu dalam waktu yang bersamaan.</p>

            <div class="my-6 p-5 rounded-2xl bg-emerald-50 border-l-4 border-[#0e7c47] text-emerald-950">
                <div class="flex items-start gap-3">
                    <i class="fa-solid fa-triangle-exclamation text-[#0e7c47] text-xl mt-0.5 shrink-0"></i>
                    <div>
                        <h4 class="font-bold text-[#0e7c47] text-base mb-1">Fakta Medis Penting:</h4>
                        <p class="text-sm leading-relaxed">Batu empedu yang menyumbat saluran empedu dapat menyebabkan komplikasi serius seperti radang kantung empedu (kolesistitis), infeksi saluran empedu (kolangitis), hingga radang pankreas akut (pankreatitis).</p>
                    </div>
                </div>
            </div>

            <h2>Mengapa Nyeri Menjalar Hingga ke Bahu Kanan?</h2>
            <p>Secara anatomis, kantung empedu dipersarafi oleh serabut saraf yang juga terhubung dengan saraf frenikus (phrenic nerve). Saraf frenikus ini berasal dari leher dan melintasi diafragma.</p>
            <p>Ketika kantung empedu mengalami peradangan atau kejang akibat batu empedu yang menyumbat saluran, sinyal rasa sakit dikirim melalui jalur saraf ini. Otak mempersepsikan rasa sakit ini tidak hanya di perut kanan atas, tetapi juga sebagai <em>referred pain</em> (nyeri alih) di bagian punggung di antara tulang belikat dan bahu kanan.</p>

            <h2>Gejala Utama Batu Empedu yang Harus Diwaspadai</h2>
            <p>Banyak kasus batu empedu yang awalnya tidak bergejala (dikenal sebagai <em>silent gallstones</em>). Namun saat batu menyumbat aliran empedu, gejala yang muncul dapat meliputi:</p>
            <ul>
                <li><strong>Kolik Bilier:</strong> Nyeri mendadak dan semakin intens di bagian tengah atas perut atau kanan atas.</li>
                <li><strong>Nyeri Menjalar:</strong> Rasa sakit menyebar ke punggung atau bahu kanan.</li>
                <li><strong>Mual dan Muntah:</strong> Sering kali dipicu setelah konsumsi makanan bersantan, gorengan, atau berlemak tinggi.</li>
                <li><strong>Kuning pada Kulit dan Mata (Ikterus):</strong> Jika batu menyumbat saluran empedu utama.</li>
                <li><strong>Demam dan Menggigil:</strong> Tanda infeksi aktif yang membutuhkan penanganan medis darurat.</li>
            </ul>

            <h2>Faktor Risiko Pembentukan Batu Empedu</h2>
            <p>Kondisi medis mengenali faktor risiko batu empedu dengan rumus <strong>4F (Female, Forty, Fat, Fertile)</strong>:</p>
            <ol>
                <li><strong>Wanita (Female):</strong> Hormon estrogen meningkatkan kadar kolesterol dalam cairan empedu.</li>
                <li><strong>Usia 40 Tahun ke Atas (Forty):</strong> Risiko pembentukan batu empedu meningkat seiring bertambahnya usia.</li>
                <li><strong>Kelebihan Berat Badan (Fat/Obesity):</strong> Obesitas menyebabkan hati memproduksi lebih banyak kolesterol.</li>
                <li><strong>Usia Subur / Pernah Melahirkan (Fertile):</strong> Perubahan hormon kehamilan dapat memengaruhi pengosongan kantung empedu.</li>
            </ol>

            <h2>Bagaimana Penanganan Medis di RSU Fikri Medika?</h2>
            <p>Di <strong>RSU Fikri Medika Karawang</strong>, dokter spesialis bedah dan penyakit dalam kami dilengkapi dengan fasilitas penunjang modern untuk mendiagnosis dan menangani batu empedu secara tepat:</p>
            <ul>
                <li><strong>USG Abdomen:</strong> Prosedur pencitraan non-invasif lini pertama yang sangat akurat untuk mendeteksi batu empedu.</li>
                <li><strong>Pemeriksaan Laboratorium Lengkap:</strong> Evaluasi fungsi hati, bilirubin, dan enzim pencernaan.</li>
                <li><strong>Laparoskopi Kolesistektomi (Operasi Minimal Invasif):</strong> Pengangkatan kantung empedu melalui sayatan luka kecil (keyhole surgery), memberikan masa pemulihan yang jauh lebih cepat dan minim nyeri pasca operasi.</li>
            </ul>

            <div class="my-6 p-5 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900">
                <h4 class="font-bold text-amber-900 text-base mb-1"><i class="fa-solid fa-notes-medical mr-2 text-amber-600"></i>Kapan Harus Segera ke IGD RSU Fikri Medika?</h4>
                <p class="text-sm leading-relaxed">Segera kunjungi <strong>Instalasi Gawat Darurat (IGD 24 Jam) RSU Fikri Medika</strong> apabila nyeri perut kanan atas berlangsung lebih dari 2 jam tanpa mereda, disertai demam tinggi, menggigil hebat, atau kulit dan mata tampak menguning.</p>
            </div>',
            'en' => '<p class="lead">Have you ever experienced sudden, stabbing pain in your upper right abdomen after consuming fatty foods, radiating toward your back or right shoulder? Do not ignore these symptoms, as they may indicate <strong>gallstones (cholelithiasis)</strong>.</p>
            <h2>Understanding Gallstones</h2>
            <p>Gallstones are hardened deposits of digestive fluid that form within the gallbladder. Modern laparoscopic cholecystectomy procedures available at RSU Fikri Medika offer rapid recovery with minimal scarring.</p>'
        ],
        'category' => ['id' => 'Edukasi Kesehatan', 'en' => 'Health Education'],
        'author_id' => $admin->id,
        'is_published' => true,
        'published_at' => now(),
    ]
);

echo "Successfully created / updated batu empedu article!\n";
