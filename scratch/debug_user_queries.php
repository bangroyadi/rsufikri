<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Services\SmartAssistantService;

$service = new SmartAssistantService();

echo "=== TEST 1: saya mau ke poli anak ===\n";
$res1 = $service->processQuery("saya mau ke poli anak", 'session_debug');
echo "Intent: " . ($res1['intent'] ?? 'null') . "\n";
echo "Score: " . ($res1['score'] ?? 0) . "\n";
echo "Answer: " . $res1['answer'] . "\n\n";

echo "=== TEST 2: dokter bedah hari ini ada tidak ? ===\n";
$res2 = $service->processQuery("dokter bedah hari ini ada tidak ?", 'session_debug');
echo "Intent: " . ($res2['intent'] ?? 'null') . "\n";
echo "Score: " . ($res2['score'] ?? 0) . "\n";
echo "Answer: " . $res2['answer'] . "\n\n";
