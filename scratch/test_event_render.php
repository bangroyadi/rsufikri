<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\HospitalEvent;
use App\Models\HospitalProfile;

echo "Total events in DB: " . HospitalEvent::count() . PHP_EOL;

// Test Public View
$events = HospitalEvent::where('is_active', true)->orderBy('order', 'asc')->get();
$featuredEvent = HospitalEvent::where('is_active', true)->where('is_featured', true)->first();
$categories = HospitalEvent::where('is_active', true)->pluck('category')->unique()->values();
$profile = HospitalProfile::first();
$category = 'all';
$query = '';

$html = view('public.event.index', compact('events', 'featuredEvent', 'categories', 'profile', 'category', 'query'))->render();
echo "Public Event View rendered successfully! HTML length: " . strlen($html) . " bytes." . PHP_EOL;

// Test Admin View
view()->share('errors', new \Illuminate\Support\ViewErrorBag);
$adminHtml = view('admin.events.index', compact('events'))->render();
echo "Admin Event View rendered successfully! HTML length: " . strlen($adminHtml) . " bytes." . PHP_EOL;
