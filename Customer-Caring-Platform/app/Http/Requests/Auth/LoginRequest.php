<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Exception;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ];

        // Add OTP validation rule if OTP is expected
        if ($this->isOtpRequest()) {
            $rules['otp'] = ['required', 'numeric'];
        }

        return $rules;
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        // If OTP is required, validate OTP
        if ($this->isOtpRequest()) {
            $this->validateOtp();
        } else {
            // Standard authentication
            if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
                RateLimiter::hit($this->throttleKey());

                throw ValidationException::withMessages([
                    'email' => trans('auth.failed'),
                ]);
            }

            RateLimiter::clear($this->throttleKey());

            // Generate and send OTP
            $this->sendOtp($this->input('email'));
        }
    }

    /**
     * Check if OTP validation is required.
     */
    protected function isOtpRequest(): bool
    {
        return Session::has('otp') && $this->filled('otp');
    }

    /**
     * Validate OTP.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateOtp(): void
    {
        $inputOtp = $this->input('otp');
        $sessionOtp = Session::get('otp');

        if ($inputOtp != $sessionOtp) {
            throw ValidationException::withMessages([
                'otp' => trans('auth.otp_failed'),
            ]);
        }

        // Clear OTP from session after validation
        Session::forget('otp');
    }

    /**
     * Generate and send OTP.
     */
    public function sendOtp($email): void
    {
        $otp = rand(100000, 999999); // Generate a 6-digit OTP

        // Store OTP and chat ID in session
        $chat_id = ''; // Replace with the fixed chat ID
        Session::put('otp', $otp);
        Session::put('chat_id', $chat_id);

        // Send the OTP via Telegram using cURL
        $bot_api_key  = ''; // Replace with your bot API key
        $bot_username = ''; // Replace with your bot username

        $message = "Your OTP code is: $otp\nEmail: $email";

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
                throw new Exception('Failed to send OTP: ' . $response_data['description']);
            }
        }
        curl_close($ch);
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}
