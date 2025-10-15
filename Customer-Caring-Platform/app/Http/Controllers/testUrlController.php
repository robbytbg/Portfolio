<?php

// Include the Laravel bootstrap script
require __DIR__ . '/../../../testUrlBootstrap.php'; // Adjusted path to root

// Use the Laravel application instance
use App\Http\Controllers\UrlController;

// Create an instance of UrlController
$controller = new UrlController();

// Generate URLs
$registerUrl = $controller->generateRegisterUrl();
$loginUrl = $controller->generateLoginUrl();

// Print generated URLs
echo "Generated Register URL: $registerUrl\n";
echo "Generated Login URL: $loginUrl\n";
