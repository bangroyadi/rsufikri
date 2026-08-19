<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Services\SmartAssistantService;

$service = new SmartAssistantService();

$testCases = [
    // 1. Hospital Hours variations
    'Jam buka rumah sakit?' => 'hospital_hours',
    'RS Fikri buka hari Minggu?' => 'hospital_hours',
    'kalau malam masih buka?' => 'hospital_hours',
    'minggu buka gak?' => 'hospital_hours',
    
    // 2. Doctor Search & Schedule
    'Ada dokter mata?' => 'doctor_schedule',
    'Dokter spesialis mata siapa saja?' => 'doctor_schedule',
    'Ada dokter anak hari ini?' => 'doctor_schedule',
    'Dokter anak hari Senin ada siapa?' => 'doctor_schedule',
    'jadwal dokter penyakit dalam' => 'doctor_schedule',
    
    // 3. Typo Tolerance (Fuzzy Matching)
    'doktr matah' => 'doctor_schedule',
    'dftar onlin' => 'registration_online',
    'jam bukanya kpn' => 'hospital_hours',
    
    // 4. Registration & BPJS
    'Saya mau daftar rawat jalan' => 'outpatient',
    'Bagaimana cara daftar online?' => 'registration_online',
    'Bagaimana cara menggunakan BPJS?' => 'registration_bpjs',
    'Apakah menerima pasien BPJS?' => 'registration_bpjs',
    
    // 5. Inpatient & VIP
    'Ada kamar VIP?' => 'inpatient',
    'Bagaimana cara daftar rawat inap?' => 'inpatient',
    
    // 6. MCU
    'Ada layanan MCU?' => 'mcu',
    'Berapa harga MCU?' => 'mcu',
    
    // 7. Location & Contact
    'Lokasi RS di mana?' => 'hospital_location',
    'Nomor telepon rumah sakit?' => 'hospital_contact',
    'Bagaimana cara ke IGD?' => 'emergency',
    
    // 8. Layanan Unggulan
    'Apa saja layanan unggulan?' => 'service_search',
    
    // 9. Medical Safety Filter
    'Kenapa dada saya sakit?' => 'medical_disclaimer',
    'Resep obat batuk berdahak' => 'medical_disclaimer',
    
    // 10. Fallback & Unknown Question
    'Bisa parkir helikopter di mana?' => 'fallback_unknown',
];

echo "========================================================\n";
echo "       TANYA KAKAK FIKRI - NLP ENGINE TEST SUITE       \n";
echo "========================================================\n\n";

$passed = 0;
$total = count($testCases);

foreach ($testCases as $query => $expectedIntent) {
    $result = $service->processQuery($query, 'test_session_123');
    $detectedIntent = $result['intent'] ?? 'null';
    $score = $result['score'] ?? 0;
    
    $isMatch = ($detectedIntent === $expectedIntent || str_contains($detectedIntent, $expectedIntent));
    
    if ($isMatch) {
        $passed++;
        echo "✅ PASS | Query: \"{$query}\"\n";
        echo "         Intent: {$detectedIntent} | Score: {$score}%\n";
    } else {
        echo "❌ FAIL | Query: \"{$query}\"\n";
        echo "         Expected: {$expectedIntent} | Got: {$detectedIntent} (Score: {$score}%)\n";
    }
    echo "--------------------------------------------------------\n";
}

echo "\n========================================================\n";
echo "Test Result: {$passed} / {$total} Passed (" . round(($passed / $total) * 100) . "%)\n";
echo "========================================================\n\n";

// Test Context Memory
echo "=== Testing Context Conversation ===\n";
$service->resetSession();

// Step 1: User asks "ada dokter mata?"
$res1 = $service->processQuery("ada dokter mata?", 'test_session_context');
echo "User Step 1: \"ada dokter mata?\"\n";
echo "Bot Intent: " . ($res1['intent'] ?? 'null') . "\n";

// Step 2: User asks "jadwalnya kapan?"
$res2 = $service->processQuery("jadwalnya kapan?", 'test_session_context');
echo "User Step 2: \"jadwalnya kapan?\"\n";
echo "Bot Intent: " . ($res2['intent'] ?? 'null') . "\n";
echo "Bot Answer snippet: " . substr(strip_tags($res2['answer']), 0, 100) . "...\n";

// Test Unrecognized Question Logger
echo "\n=== Testing Unrecognized Question Database Logging ===\n";
$unrecQuery = "apakah ada helipad pendaratan helikopter di lantai atas?";
$unrecRes = $service->processQuery($unrecQuery, 'test_unrec_session');
$unrecDb = \App\Models\ChatbotUnrecognizedQuery::where('raw_query', $unrecQuery)->first();

if ($unrecDb) {
    echo "✅ Unrecognized question was successfully logged to `chatbot_unrecognized_queries` table!\n";
    echo "   DB ID: {$unrecDb->id} | Query: \"{$unrecDb->raw_query}\" | Confidence: {$unrecDb->confidence_score}%\n";
} else {
    echo "❌ Unrecognized query logging test failed.\n";
}

