<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$docs = App\Models\Doctor::all();
foreach ($docs as $d) {
    echo "ID: {$d->id}, Name: {$d->name}, Slug: '{$d->slug}'" . PHP_EOL;
}
