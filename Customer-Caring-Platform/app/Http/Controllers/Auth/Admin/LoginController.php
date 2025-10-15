<?php

namespace App\Http\Controllers\Auth\Admin;
use App\Http\Controllers\Auth\Admin\RegisterController; // Import the RegisterController

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AdminLoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Exception;
use Illuminate\View\View; // Import the View facade

class LoginController extends Controller
{
    public function create(Request $request, $token = null): View
    {
        // If a token is provided, validate it
        if ($token) {
            if (! $request->hasValidSignature() || ! $this->validateToken($token)) {
                abort(403, 'Invalid or expired URL.');
            }
        }
    
        return view('admin.auth.login');
    }
    
    protected function validateToken($token)
    {
        // Implement token validation logic
        return Cache::has('login_token_' . $token);
    }

    public function generateUrlsAndSend()
    {
        // Create an instance of RegisterController
        $registerController = new RegisterController();

        // Generate the register URL using the RegisterController
        $registerUrl = $registerController->generateRegisterUrl();    
        
        // Generate the login URL
        $loginToken = Str::random(32);
        $loginUrl = URL::temporarySignedRoute(
            'admin.login.token', // Update to the correct route name
            now()->addMinutes(30),
            ['token' => $loginToken]
        );
        Cache::put('login_token_' . $loginToken, true, now()->addMinutes(30));

        // Combine both URLs into a single message
        $message = "Register URL: $registerUrl\nLogin URL: $loginUrl";

        // Send the combined message to Telegram
        $this->sendTelegramMessage($message);
        return redirect('/');
    }

    protected function sendTelegramMessage($message)
    {
        $chat_id = ''; 
        $bot_api_key  = ''; 

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'chat_id' => $chat_id,
            'text'    => $message,
        ]));
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects
        curl_setopt($ch, CURLOPT_CAINFO, ""); 
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new Exception('cURL error: ' . curl_error($ch));
        } else {
            $response_data = json_decode($response, true);
            if (!$response_data['ok']) {
                throw new Exception('Failed to send message: ' . $response_data['description']);
            }
        }
        curl_close($ch);
    }

    public function store(AdminLoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('admin.users.index', absolute: false));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
