<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

foreach (\App\Models\Doctor::with('polyclinic', 'schedules')->get() as $d) {
    $poli = $d->polyclinic ? json_encode($d->polyclinic->name) : 'none';
    $spec = json_encode($d->specialty);
    echo "ID: {$d->id} | {$d->name} | Poli: {$poli} | Spec: {$spec} | Sched count: {$d->schedules->count()}\n";
}
