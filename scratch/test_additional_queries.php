<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Services\SmartAssistantService;

$service = new SmartAssistantService();

echo "=== TEST 3: ada dokter anak hari ini? ===\n";
$res3 = $service->processQuery("ada dokter anak hari ini?", 'session_test_3');
echo strip_tags($res3['answer']) . "\n\n";

echo "=== TEST 4: dokter bedah hari senin ada? ===\n";
$res4 = $service->processQuery("dokter bedah hari senin ada?", 'session_test_4');
echo strip_tags($res4['answer']) . "\n\n";

echo "=== TEST 5: poli mata buka hari apa? ===\n";
$res5 = $service->processQuery("poli mata buka hari apa?", 'session_test_5');
echo strip_tags($res5['answer']) . "\n\n";
