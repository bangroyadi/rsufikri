<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== DOCTORS COUNT ===" . PHP_EOL;
echo "Total Doctors: " . App\Models\Doctor::count() . PHP_EOL;
echo "Total Polyclinics: " . App\Models\Polyclinic::count() . PHP_EOL;
echo "Total Schedules: " . App\Models\DoctorSchedule::count() . PHP_EOL;
echo "Total Articles: " . App\Models\Article::count() . PHP_EOL;

echo PHP_EOL . "=== POLYCLINICS ===" . PHP_EOL;
foreach(App\Models\Polyclinic::all() as $p) {
    echo "- [ID: {$p->id}] slug: '{$p->slug}', name: '{$p->tr('name')}', doctors count: " . $p->doctors()->count() . PHP_EOL;
}

echo PHP_EOL . "=== SAMPLE DOCTORS ===" . PHP_EOL;
foreach(App\Models\Doctor::with('polyclinic')->take(10)->get() as $d) {
    echo "- [ID: {$d->id}] {$d->name}, {$d->title_degree} | Poli: " . ($d->polyclinic?->tr('name') ?? 'None') . " | Spec: " . $d->tr('specialty') . PHP_EOL;
}

echo PHP_EOL . "=== ARTICLES ===" . PHP_EOL;
foreach(App\Models\Article::all() as $a) {
    echo "- [ID: {$a->id}] slug: '{$a->slug}', title: '{$a->tr('title')}'" . PHP_EOL;
}
