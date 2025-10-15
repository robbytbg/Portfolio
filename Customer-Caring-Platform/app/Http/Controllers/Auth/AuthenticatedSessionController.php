<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Exception;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');

        // Validate user credentials
        if (Auth::attempt($credentials)) {
            // Generate and send OTP with email
            $request->sendOtp($credentials['email']);

            // Redirect to OTP verification page
            return redirect()->route('user_sheet.verify-otp');
        }

        // Authentication failed
        return redirect()->back()->withErrors(['login' => 'Invalid credentials']);
    }

    /**
     * Show the OTP verification form.
     */
    public function showOtpForm(): View
    {
        return view('auth.verify-otp');
    }

    /**
     * Verify OTP.
     */
    public function verifyOtp(Request $request): RedirectResponse
    {
        $request->validate([
            'otp' => 'required|numeric',
        ]);

        $inputOtp = $request->input('otp');
        $sessionOtp = Session::get('otp');

        if ($inputOtp == $sessionOtp) {
            // OTP is correct, proceed with the login
            Session::forget('otp'); // Clear OTP from session
            return redirect()->intended(route('user_sheet.index'));
        }

        return redirect()->back()->withErrors(['otp' => 'Invalid OTP']);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
