<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\HospitalProfile;

try {
    $profile = HospitalProfile::first();
    $title = 'Profil RSU Fikri Medika';
    $category = 'Profil';
    $slug = 'profil';

    $html = view('public.profil', compact('profile', 'title', 'category', 'slug'))->render();
    echo "Profil View rendered successfully! Length: " . strlen($html) . " bytes\n";
} catch (\Throwable $e) {
    echo "Error rendering profil: " . $e->getMessage() . "\n" . $e->getTraceAsString();
}
