<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$cols = Illuminate\Support\Facades\Schema::getColumnListing('polyclinics');
echo json_encode($cols) . PHP_EOL;

$polis = App\Models\Polyclinic::all(['id', 'slug', 'name', 'icon', 'image']);
echo "Total polis: " . $polis->count() . PHP_EOL;
foreach ($polis->take(5) as $p) {
    echo "ID: {$p->id} | Slug: {$p->slug} | Name: " . json_encode($p->name) . " | Image: {$p->image}" . PHP_EOL;
}
