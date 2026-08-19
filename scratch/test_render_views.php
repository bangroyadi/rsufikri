<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Article;
use App\Models\HospitalProfile;

try {
    $article = Article::where('slug', 'nyeri-menjalar-ke-bahu-kanan-bisa-jadi-batu-empedu')->first();
    $profile = HospitalProfile::first();

    $htmlShow = view('public.artikel.show', compact('article', 'profile'))->render();
    echo "Detail Page rendered successfully! Length: " . strlen($htmlShow) . " bytes\n";

    $articles = Article::where('is_published', true)->paginate(9);
    $htmlIndex = view('public.artikel.index', compact('articles', 'profile'))->render();
    echo "Index Page rendered successfully! Length: " . strlen($htmlIndex) . " bytes\n";

} catch (\Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n" . $e->getTraceAsString();
}
