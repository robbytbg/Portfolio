<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
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
        
        <!-- Form Container -->
        <div style="display: flex; flex-direction: row; max-width: 900px; width: 100%; padding: 2rem; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2); border-radius: 10px; background-color: white; z-index: 2; position: relative;">
            

            
            <!-- OTP Form -->
            <div style="flex: 1; margin-right: 20px;">
                <!-- Stepper -->

                <h1 style="text-align: center; margin-bottom: 1rem; font-size: 1rem; color: #333333;">Verify OTP</h1>
                <form action="{{ route('user_sheet.verify-otp') }}" method="POST">
                    @csrf
                    <label for="otp" style="font-weight: bold; color: #4a5568;">Enter OTP:</label>
                    <input type="text" id="otp" name="otp" required placeholder="" style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 0.25rem; font-size: 0.875rem; margin-bottom: 1rem;" />
                    <button type="submit" style="background-color: #d12f29; color: white; padding: 0.75rem 1.5rem; border-radius: 0.25rem; font-weight: bold; border: none; width: 100%;">Verify OTP</button>
                </form>
            </div>

            <!-- Separator -->
            <div style="width: 1px; background-color: #d1d5db; margin: 0 20px;"></div>

            <!-- Welcome Message Container -->
            <div style="flex: 1; padding: 20px;">
                <h3 style="font-size: 18px; margin-bottom: 15px;">Welcome to the Application!</h3>
                <p style="margin-bottom: 10px;">Before proceeding, please note the following:</p>
                <ul style="color: #d12f29; margin-left: 20px; font-size: 14px;">
                    <li>Ensure you enter the correct OTP sent to your email or phone.</li>
                    <li>If you do not receive the OTP, you can resend it.</li>
                    <li>If you continue to face issues, please contact support.</li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
