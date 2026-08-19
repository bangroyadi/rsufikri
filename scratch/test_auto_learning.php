<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\ChatbotUnrecognizedQuery;
use App\Models\KnowledgeBase;
use App\Services\ChatbotAutoLearningService;

$service = app(ChatbotAutoLearningService::class);

// Seed some test unresolved queries
ChatbotUnrecognizedQuery::create([
    'raw_query'        => 'asdfghjkl12345',
    'normalized_query' => 'asdfghjkl12345',
    'confidence_score' => 0.0,
    'is_resolved'      => false,
]);

ChatbotUnrecognizedQuery::create([
    'raw_query'        => 'cara pendaftaran lewat hp wa',
    'normalized_query' => 'cara pendaftaran lewat hp wa',
    'confidence_score' => 55.0,
    'is_resolved'      => false,
]);

ChatbotUnrecognizedQuery::create([
    'raw_query'        => 'dr naman khalid sp a jadwalnya',
    'normalized_query' => 'dr naman khalid sp a jadwalnya',
    'confidence_score' => 60.0,
    'is_resolved'      => false,
]);

echo "=== Running Auto Learning Service ===\n";
$stats = $service->processPendingQueries();

echo "Total Processed: {$stats['total']}\n";
echo "• Spam Cleaned : {$stats['spam_cleaned']}\n";
echo "• Auto Mapped  : {$stats['auto_mapped']}\n";
echo "• Skipped      : {$stats['skipped']}\n\n";

$spamCheck = ChatbotUnrecognizedQuery::where('raw_query', 'asdfghjkl12345')->first();
echo "Spam Query Status: " . ($spamCheck->is_resolved ? 'RESOLVED' : 'UNRESOLVED') . " | Notes: " . $spamCheck->admin_notes . "\n";

$mappedCheck = ChatbotUnrecognizedQuery::where('raw_query', 'cara pendaftaran lewat hp wa')->first();
echo "Mapped Query Status: " . ($mappedCheck->is_resolved ? 'RESOLVED' : 'UNRESOLVED') . " | Notes: " . $mappedCheck->admin_notes . "\n";

$docCheck = ChatbotUnrecognizedQuery::where('raw_query', 'dr naman khalid sp a jadwalnya')->first();
echo "Doctor Master Status: " . ($docCheck->is_resolved ? 'RESOLVED' : 'UNRESOLVED') . " | Notes: " . $docCheck->admin_notes . "\n";
