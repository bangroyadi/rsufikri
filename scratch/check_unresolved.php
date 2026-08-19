<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\ChatbotUnrecognizedQuery;

$unresolved = ChatbotUnrecognizedQuery::where('is_resolved', false)->get();
echo "Total Unresolved: " . $unresolved->count() . "\n";
foreach ($unresolved as $q) {
    echo "ID: {$q->id} | Raw: '{$q->raw_query}' | Confidence: {$q->confidence_score}%\n";
}
