<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

$doctors = DB::table('doctors')->get();
$usedSlugs = [];

foreach ($doctors as $doctor) {
    $baseSlug = Str::slug($doctor->name);
    if (empty($baseSlug)) {
        $baseSlug = 'dokter-' . $doctor->id;
    }

    $slug = $baseSlug;
    $counter = 1;
    while (in_array($slug, $usedSlugs) || DB::table('doctors')->where('slug', $slug)->where('id', '!=', $doctor->id)->exists()) {
        $slug = "{$baseSlug}-{$counter}";
        $counter++;
    }

    $usedSlugs[] = $slug;
    DB::table('doctors')->where('id', $doctor->id)->update(['slug' => $slug]);
    echo "Doctor ID {$doctor->id} ('{$doctor->name}') => slug set to '{$slug}'" . PHP_EOL;
}
