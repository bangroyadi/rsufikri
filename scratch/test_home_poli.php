<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;

try {
    $controller = app(HomeController::class);
    $req = Request::create('/', 'GET');
    $res = $controller->index($req);
    $html = $res->render();
    
    $hasPoliSection = str_contains($html, 'Poliklinik & Spesialisasi');
    $hasDoctorLink = str_contains($html, 'dokter-di-karawang') || str_contains($html, 'penyakit-dalam-karawang');
    $hasDoctorsInModal = str_contains($html, 'selectedPoliDoctors');
    
    echo "Homepage Render: OK (" . strlen($html) . " bytes)" . PHP_EOL;
    echo "Poli Section: " . ($hasPoliSection ? "PASS" : "FAIL") . PHP_EOL;
    echo "Doctor Specialty Links: " . ($hasDoctorLink ? "PASS" : "FAIL") . PHP_EOL;
    echo "Doctors in Modal: " . ($hasDoctorsInModal ? "PASS" : "FAIL") . PHP_EOL;
} catch (\Throwable $e) {
    echo "FAIL: " . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine() . PHP_EOL;
}
