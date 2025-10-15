<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
</head>
<body style="margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif;">
    <div style="position: relative; display: flex; justify-content: center; align-items: center; height: 100vh; background: linear-gradient(to bottom, rgba(153, 0, 0, 0.4), #fff); overflow: hidden;">
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 0; overflow: hidden;">
            <!-- Red wave -->
            <div style="position: absolute; top: 0; left: 0; width: 1100px; height: 100%; background: url('data:image/svg+xml,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; viewBox=&quot;0 0 800 1440&quot;><path fill=&quot;%23d12f29&quot; fill-opacity=&quot;1&quot; d=&quot;M192,0L176,60C160,120,128,240,138.7,360C149,480,203,600,213.3,720C224,840,192,960,160,1080C128,1200,96,1320,80,1380L64,1440L0,1440L0,0Z&quot;/></svg>') no-repeat; background-size: cover; opacity: 0.9;"></div>

            <!-- White wave -->
            <div style="position: absolute; top: 0; left: 0; width: 300px; height: 100%; background: url('data:image/svg+xml,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; viewBox=&quot;0 0 1600 800&quot;><path fill=&quot;%23ffffff&quot; fill-opacity=&quot;1&quot; d=&quot;M192,0L176,60C160,120,128,240,138.7,360C149,480,203,600,213.3,720C224,840,192,960,160,1080C128,1200,96,1320,80,1380L64,1440L0,1440L0,0Z&quot;/></svg>') no-repeat; background-size: cover; opacity: 0.9;"></div>
        </div>

        <!-- Form Container -->
        <div style="display: flex; flex-direction: column; max-width: 400px; width: 100%; padding: 2rem; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2); border-radius: 10px; background-color: white; z-index: 2; position: relative;">
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <h3 style="text-align: center; margin-bottom: 1rem; font-size: 1rem; color: #333333;">Admin Login Page</h3>
            <form method="POST" action="{{ route('admin.login') }}">
                @csrf

                <!-- Email Address -->
                <div style="margin-bottom: 1rem;">
                    <label for="email" style="font-weight: bold; color: #4a5568;">{{ __('Email') }}</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 0.25rem; font-size: 1rem;" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" style="color: #e53e3e; font-size: 0.875rem;" />
                </div>

                <!-- Password -->
                <div style="margin-bottom: 1rem;">
                    <label for="password" style="font-weight: bold; color: #4a5568;">{{ __('Password') }}</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password" style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 0.25rem; font-size: 1rem;" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" style="color: #e53e3e; font-size: 0.875rem;" />
                </div>

                <!-- Remember Me -->
                <div style="margin-bottom: 1rem;">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span style="margin-left: 0.5rem; font-size: 0.875rem; color: #4a5568;">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem;">
                    @if (Route::has('password.request'))
                        <a style="font-size: 0.875rem; color: #4a5568; text-decoration: underline;" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <button type="submit" style="background-color: #d12f29; color: white; padding: 0.75rem 1.5rem; border-radius: 0.25rem; font-weight: bold; border: none;">{{ __('Log in') }}</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
