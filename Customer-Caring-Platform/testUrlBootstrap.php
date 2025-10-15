<?php

require __DIR__ . '/bootstrap-laravel.php'; // Bootstrap the Laravel application

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\UrlController;

// Create a dummy request object (needed for URL generation)
$request = Request::create('/');

// Generate URLs
$controller = new UrlController();
$registerUrl = $controller->generateRegisterUrl();
$loginUrl = $controller->generateLoginUrl();

// Print generated URLs
echo "Generated Register URL: $registerUrl\n";
echo "Generated Login URL: $loginUrl\n";
