<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$articles = App\Models\Article::all();
echo "Total Articles: " . $articles->count() . "\n";
foreach ($articles as $a) {
    echo "====================================\n";
    echo "- ID: {$a->id}, Slug: {$a->slug}\n";
    echo "- Title (ID): " . ($a->title['id'] ?? '') . "\n";
    echo "- Category (ID): " . ($a->category['id'] ?? '') . "\n";
    echo "- Excerpt: " . ($a->excerpt['id'] ?? '') . "\n";
    echo "- Thumbnail: {$a->thumbnail}\n";
}

