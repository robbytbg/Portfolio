<?php

require __DIR__ . '/vendor/autoload.php'; // Include Composer's autoload file

$app = require_once __DIR__ . '/bootstrap/app.php'; // Bootstrap the Laravel application

// Initialize the HTTP Kernel
$app->make(Illuminate\Contracts\Http\Kernel::class)->bootstrap();

return $app;
