<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

foreach (\App\Models\Polyclinic::with('doctors.schedules')->get() as $p) {
    $pName = is_array($p->name) ? ($p->name['id'] ?? '') : $p->name;
    $docCount = $p->doctors->count();
    echo "Poli: {$p->id} | {$pName} ({$p->slug}) | Doctors: {$docCount}\n";
    foreach ($p->doctors as $d) {
        $scheds = $d->schedules->map(fn($s) => "{$s->day}: " . substr($s->start_time, 0, 5) . "-" . substr($s->end_time, 0, 5))->join(', ');
        echo "  - {$d->name} ({$d->title_degree}) | Schedules: [{$scheds}]\n";
    }
}
