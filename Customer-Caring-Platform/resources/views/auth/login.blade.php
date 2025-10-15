<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body style="margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif;">
    <div style="position: relative; display: flex; justify-content: center; align-items: center; height: 100vh; background: linear-gradient(to bottom, rgba(153, 0, 0, 0.4), #fff); overflow: hidden;">
        <!-- Combined Wave Backgrounds -->
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 0; overflow: hidden;">
            <!-- Red wave -->
            <div style="position: absolute; top: 0; left: 0; width: 1100px; height: 100%; background: url('data:image/svg+xml,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; viewBox=&quot;0 0 800 1440&quot;><path fill=&quot;%23d12f29&quot; fill-opacity=&quot;1&quot; d=&quot;M192,0L176,60C160,120,128,240,138.7,360C149,480,203,600,213.3,720C224,840,192,960,160,1080C128,1200,96,1320,80,1380L64,1440L0,1440L0,0Z&quot;/></svg>') no-repeat; background-size: cover; opacity: 0.9;"></div>

            <!-- White wave -->
            <div style="position: absolute; top: 0; left: 0; width: 300px; height: 100%; background: url('data:image/svg+xml,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; viewBox=&quot;0 0 1600 800&quot;><path fill=&quot;%23ffffff&quot; fill-opacity=&quot;1&quot; d=&quot;M192,0L176,60C160,120,128,240,138.7,360C149,480,203,600,213.3,720C224,840,192,960,160,1080C128,1200,96,1320,80,1380L64,1440L0,1440L0,0Z&quot;/></svg>') no-repeat; background-size: cover; opacity: 0.9;"></div>
        </div>

        <!-- Form and Welcome Message Side by Side -->
        <div style="display: flex; flex-direction: row; max-width: 900px; width: 100%; padding: 2rem; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2); border-radius: 10px; background-color: white; z-index: 2; position: relative;">
            <!-- Login Form -->
            <div style="flex: 1; margin-right: 20px;">
                <!-- Session Status -->
                <div style="margin-bottom: 1rem;">
                    @if(session('status'))
                        <div style="background-color: #f7fafc; padding: 1rem; border: 1px solid #e2e8f0; border-radius: 0.25rem;">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(session('success'))
                        <div id="success-message" class="mb-4" style="background-color: #38a169; color: white; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem;">
                            {{ session('success') }}
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                var successMessage = document.getElementById('success-message');
                                if (successMessage) {
                                    alert("{{ session('success') }}");
                                }
                            });
                        </script>
                    @endif
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <h1 style="text-align: center; margin-bottom: 1rem; font-size: 1rem; color: #333333;">LOGIN</h1>
                    <!-- Email Address -->
                    <div style="margin-bottom: 1rem;">
                        <label for="email" style="font-weight: bold; color: #4a5568;">{{ __('Email') }}</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 0.25rem; font-size: 1rem;" />
                        @error('email')
                            <span style="color: #e53e3e; font-size: 0.875rem;">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div style="margin-bottom: 1rem;">
                        <label for="password" style="font-weight: bold; color: #4a5568;">{{ __('Password') }}</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password" style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 0.25rem; font-size: 1rem;" />
                        @error('password')
                            <span style="color: #e53e3e; font-size: 0.875rem;">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div style="display: flex; align-items: center; margin-bottom: 1rem;">
                        <input id="remember_me" type="checkbox" name="remember" style="margin-right: 0.5rem; border-radius: 0.25rem; border: 1px solid #cbd5e0;">
                        <label for="remember_me" style="font-size: 0.875rem; color: #4a5568;">{{ __('Remember me') }}</label>
                    </div>

                    <!-- Submit Button -->
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" style="font-size: 0.875rem; color: #4a5568; text-decoration: underline;">{{ __('Forgot your password?') }}</a>
                        @endif

                        <button type="submit" style="background-color: #d12f29; color: white; padding: 0.75rem 1.5rem; border-radius: 0.25rem; font-weight: bold; border: none;">{{ __('Log in') }}</button>
                    </div>
                </form>
            </div>

            <!-- Welcome Message Container -->
            <div style="flex: 1; padding: 20px;">
                <h3 style="font-size: 18px; margin-bottom: 15px;">Welcome to the Application!</h3>
                <p style="margin-bottom: 10px;">Before logging in, please note the following:</p>
                <ul style="color: #d12f29; margin-left: 20px; font-size: 14px;">
                    <li>You are responsible for keeping your login credentials confidential.</li>
                    <li>Do not share your login credentials with anyone.</li>
                    <li>Change your password to a strong one with numbers and letters.</li>
                    <li>* Users who misuse their credentials will face penalties.</li>
                    <li>* Do not share your password with anyone, including the admin.</li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
