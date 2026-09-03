<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$doctors = App\Models\Doctor::all();
echo "-- ==========================================" . PHP_EOL;
echo "-- SQL MIGRATION FOR HOSTING DATABASE" . PHP_EOL;
echo "-- ==========================================" . PHP_EOL . PHP_EOL;
echo "ALTER TABLE `doctors` ADD `slug` VARCHAR(255) NULL AFTER `name`;" . PHP_EOL . PHP_EOL;

foreach ($doctors as $d) {
    echo "UPDATE `doctors` SET `slug` = '{$d->slug}' WHERE `id` = {$d->id};" . PHP_EOL;
}

echo PHP_EOL . "ALTER TABLE `doctors` ADD UNIQUE KEY `doctors_slug_unique` (`slug`);" . PHP_EOL;
