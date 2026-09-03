<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;
use App\Http\Controllers\PublicDoctorController;
use App\Http\Controllers\SitemapController;
use App\Models\Doctor;
use App\Models\Polyclinic;
use App\Models\Article;

echo "========================================" . PHP_EOL;
echo "  DOCTOR SEO VERIFICATION TEST SUITE" . PHP_EOL;
echo "========================================" . PHP_EOL . PHP_EOL;

// 1. Test Doctor Hub Route
echo "1. Testing Doctor Hub (/dokter-di-karawang)..." . PHP_EOL;
try {
    $controller = app(PublicDoctorController::class);
    $req = Request::create('/dokter-di-karawang', 'GET');
    $res = $controller->hub($req);
    $html = $res->render();
    
    $hasH1 = str_contains($html, 'Dokter di Karawang');
    $hasSchema = str_contains($html, 'MedicalOrganization') || str_contains($html, 'Hospital');
    $hasDoctors = str_contains($html, 'dr. Ahmad Fauzi');
    
    echo "  - Render Status: OK (" . strlen($html) . " bytes)" . PHP_EOL;
    echo "  - H1 Tag: " . ($hasH1 ? "PASS" : "FAIL") . PHP_EOL;
    echo "  - Schema.org JSON-LD: " . ($hasSchema ? "PASS" : "FAIL") . PHP_EOL;
    echo "  - Contains Doctors: " . ($hasDoctors ? "PASS" : "FAIL") . PHP_EOL;
} catch (\Throwable $e) {
    echo "  - FAIL: " . $e->getMessage() . PHP_EOL;
}

echo PHP_EOL . "2. Testing Specialty Hubs..." . PHP_EOL;
$samplePolis = ['penyakit-dalam-karawang', 'anak-karawang', 'kandungan-karawang', 'bedah-karawang', 'mata-karawang', 'jantung-karawang', 'tht-karawang', 'saraf-karawang', 'gigi-karawang'];

foreach ($samplePolis as $poliSlug) {
    try {
        $req = Request::create('/dokter/' . $poliSlug, 'GET');
        $res = $controller->resolveDoctorRoute($req, $poliSlug);
        $html = $res->render();
        $hasH1 = str_contains($html, '<h1');
        $hasSchema = str_contains($html, 'MedicalClinic') || str_contains($html, 'Physician');
        echo "  - /dokter/{$poliSlug} => OK (H1: " . ($hasH1 ? "PASS" : "FAIL") . ", Schema: " . ($hasSchema ? "PASS" : "FAIL") . ")" . PHP_EOL;
    } catch (\Throwable $e) {
        echo "  - /dokter/{$poliSlug} => FAIL: " . $e->getMessage() . PHP_EOL;
    }
}

echo PHP_EOL . "3. Testing Individual Doctor Profile Pages..." . PHP_EOL;
$sampleDocs = Doctor::where('is_active', true)->take(5)->get();

foreach ($sampleDocs as $d) {
    try {
        $req = Request::create('/dokter/' . $d->slug, 'GET');
        $res = $controller->resolveDoctorRoute($req, $d->slug);
        $html = $res->render();
        $hasName = str_contains($html, $d->name);
        $hasPhysicianSchema = str_contains($html, '"@type": "Physician"') || str_contains($html, '"@type":"Physician"');
        $hasSchedule = str_contains($html, 'Jadwal Praktik') || str_contains($html, 'table');
        echo "  - /dokter/{$d->slug} => OK (Name: " . ($hasName ? "PASS" : "FAIL") . ", Physician Schema: " . ($hasPhysicianSchema ? "PASS" : "FAIL") . ", Schedule: " . ($hasSchedule ? "PASS" : "FAIL") . ")" . PHP_EOL;
    } catch (\Throwable $e) {
        echo "  - /dokter/{$d->slug} => FAIL: " . $e->getMessage() . PHP_EOL;
    }
}

echo PHP_EOL . "4. Testing Dynamic XML Sitemap..." . PHP_EOL;
try {
    $sitemapController = app(SitemapController::class);
    $sitemapRes = $sitemapController->index();
    $xml = $sitemapRes->getContent();
    
    $hasHub = str_contains($xml, '/dokter-di-karawang');
    $hasPoliInSitemap = str_contains($xml, '/dokter/penyakit-dalam-karawang');
    $hasDocInSitemap = str_contains($xml, '/dokter/dr-ahmad-fauzi-sppd');
    $totalUrls = substr_count($xml, '<url>');
    
    echo "  - Sitemap XML generated successfully (" . strlen($xml) . " bytes)" . PHP_EOL;
    echo "  - Total URLs in sitemap: {$totalUrls}" . PHP_EOL;
    echo "  - Contains /dokter-di-karawang: " . ($hasHub ? "PASS" : "FAIL") . PHP_EOL;
    echo "  - Contains Specialty URLs: " . ($hasPoliInSitemap ? "PASS" : "FAIL") . PHP_EOL;
    echo "  - Contains Doctor Profile URLs: " . ($hasDocInSitemap ? "PASS" : "FAIL") . PHP_EOL;
} catch (\Throwable $e) {
    echo "  - Sitemap FAIL: " . $e->getMessage() . PHP_EOL;
}

echo PHP_EOL . "5. Testing Article ID 8 Doctor Linking..." . PHP_EOL;
try {
    $article = Article::find(8);
    if ($article) {
        $hasSpecialtyLink = str_contains($article->tr('content'), '/dokter/penyakit-dalam-karawang');
        $hasDocLink = str_contains($article->tr('content'), '/dokter/dr-ahmad-fauzi-sppd');
        echo "  - Article 8 Title: " . $article->tr('title') . PHP_EOL;
        echo "  - Internal link to /dokter/penyakit-dalam-karawang: " . ($hasSpecialtyLink ? "PASS" : "FAIL") . PHP_EOL;
        echo "  - Internal link to /dokter/dr-ahmad-fauzi-sppd: " . ($hasDocLink ? "PASS" : "FAIL") . PHP_EOL;
    }
} catch (\Throwable $e) {
    echo "  - Article Test FAIL: " . $e->getMessage() . PHP_EOL;
}

echo PHP_EOL . "========================================" . PHP_EOL;
echo "  TEST SUITE COMPLETED!" . PHP_EOL;
echo "========================================" . PHP_EOL;
