<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== DOCTORS LIST & GENERATED SLUGS ===" . PHP_EOL;
$doctors = App\Models\Doctor::with(['polyclinic', 'schedules'])->get();
foreach ($doctors as $d) {
    $cleanName = trim($d->name);
    $slug = Illuminate\Support\Str::slug($cleanName);
    echo "ID: {$d->id} | Name: {$cleanName} | Title: {$d->title_degree} | Poli: " . ($d->polyclinic?->slug ?? 'none') . " | Slug: {$slug}" . PHP_EOL;
}

echo PHP_EOL . "=== POLYCLINICS LIST & SUGGESTED SEO SLUGS ===" . PHP_EOL;
$polis = App\Models\Polyclinic::all();
foreach ($polis as $p) {
    $docCount = $p->doctors()->count();
    $nameId = is_array($p->name) ? ($p->name['id'] ?? $p->name['en'] ?? '') : $p->name;
    echo "ID: {$p->id} | Slug: {$p->slug} | NameID: {$nameId} | Docs: {$docCount} | Route: /dokter/{$p->slug}-karawang" . PHP_EOL;
}
