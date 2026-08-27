<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$service = app(\App\Services\SmartAssistantService::class);

$queries = [
    'ada lowongan kerja apa aja',
    'bagaimana cara melamar kerja di rs fikri',
    'ada event apa saja yang terbaru',
    'apa visi misi rsu fikri medika',
    'layanan trauma center itu apa',
    'bagaimana fasilitas rawat inap vip',
];

foreach ($queries as $q) {
    echo "=== QUERY: $q ===" . PHP_EOL;
    $res = $service->processQuery($q);
    echo "Intent: " . ($res['intent'] ?? 'null') . " | Score: " . ($res['score'] ?? 0) . PHP_EOL;
    echo "Answer Preview: " . substr(strip_tags($res['answer'] ?? ''), 0, 150) . "..." . PHP_EOL . PHP_EOL;
}
