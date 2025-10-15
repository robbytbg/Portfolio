<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str; // For generating random strings
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UrlController extends Controller
{

public function generateRegisterUrl()
{
    $token = Str::random(32);
    $url = URL::temporarySignedRoute(
        'admin.register.token', // Update to the correct route name
        now()->addMinutes(30),
        ['token' => $token]
    );

    // Store the token in cache
    Cache::put('register_token_' . $token, true, now()->addMinutes(30));

    return $url;
}

public function generateLoginUrl()
{
    $token = Str::random(32);
    $url = URL::temporarySignedRoute(
        'admin.login.token', // Update to the correct route name
        now()->addMinutes(30),
        ['token' => $token]
    );

    // Store the token in cache
    Cache::put('login_token_' . $token, true, now()->addMinutes(30));

    return $url;
}

}
