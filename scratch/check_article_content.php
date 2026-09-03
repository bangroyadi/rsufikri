<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$art = App\Models\Article::where('slug', 'like', '%penyakit-dalam%')->first();
if ($art) {
    echo "Found Article ID: " . $art->id . PHP_EOL;
    echo "Title: " . $art->tr('title') . PHP_EOL;
    echo "Excerpt: " . $art->tr('excerpt') . PHP_EOL;
    echo "Content Length: " . strlen($art->tr('content')) . PHP_EOL;
    echo "First 500 chars of content:" . PHP_EOL;
    echo substr($art->tr('content'), 0, 500) . PHP_EOL;
} else {
    echo "Article not found" . PHP_EOL;
}
