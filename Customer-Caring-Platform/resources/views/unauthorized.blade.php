<!-- resources/views/unauthorized.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unauthorized</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body style="margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif;">
    <div style="position: relative; display: fl ex; justify-content: center; align-items: center; height: 100vh; background: linear-gradient(to bottom, rgba(153, 0, 0, 0.4), #fff); overflow: hidden;">
        <!-- Combined Wave Backgrounds -->
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 0; overflow: hidden;">
            <!-- Red wave -->
            <div style="position: absolute; top: 0; left: 0; width: 1100px; height: 100%; background: url('data:image/svg+xml,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; viewBox=&quot;0 0 800 1440&quot;><path fill=&quot;%23d12f29&quot; fill-opacity=&quot;1&quot; d=&quot;M192,0L176,60C160,120,128,240,138.7,360C149,480,203,600,213.3,720C224,840,192,960,160,1080C128,1200,96,1320,80,1380L64,1440L0,1440L0,0Z&quot;/></svg>') no-repeat; background-size: cover; opacity: 0.9;"></div>

            <!-- White wave -->
            <div style="position: absolute; top: 0; left: 0; width: 300px; height: 100%; background: url('data:image/svg+xml,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; viewBox=&quot;0 0 1600 800&quot;><path fill=&quot;%23ffffff&quot; fill-opacity=&quot;1&quot; d=&quot;M192,0L176,60C160,120,128,240,138.7,360C149,480,203,600,213.3,720C224,840,192,960,160,1080C128,1200,96,1320,80,1380L64,1440L0,1440L0,0Z&quot;/></svg>') no-repeat; background-size: cover; opacity: 0.9;"></div>
        </div>

        <!-- Unauthorized Message Container -->
        <div style="max-width: 600px; width: 100%; padding: 2rem; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2); border-radius: 10px; background-color: white; z-index: 2; position: relative; text-align: center;">
            <div class="alert alert-danger">
                <h1 style="font-size: 2rem; margin-bottom: 1rem; color: #d12f29;">Unauthorized</h1>
                <p style="font-size: 1rem; margin-bottom: 1.5rem; color: #333;">You do not have permission to access this page. Please contact the administrator if you believe this is a mistake.</p>
                <a href="{{ route('login') }}" class="btn btn-primary" style="background-color: #d12f29; color: white; padding: 0.75rem 1.5rem; border-radius: 0.25rem; text-decoration: none; font-weight: bold;">Login again?</a>
            </div>
        </div>
    </div>
</body>
</html>
