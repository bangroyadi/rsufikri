<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;

try {
    $req = Request::create('/layanan/unggulan', 'GET');
    $res = $app->handle($req);
    echo "Status Code: " . $res->getStatusCode() . PHP_EOL;
    if ($res->getStatusCode() === 200) {
        echo "Layanan Unggulan Page Rendered OK (" . strlen($res->getContent()) . " bytes)" . PHP_EOL;
    } else {
        echo "Response Error: " . $res->getContent() . PHP_EOL;
    }
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine() . PHP_EOL;
}
