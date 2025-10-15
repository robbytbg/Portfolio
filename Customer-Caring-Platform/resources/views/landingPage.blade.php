<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Our Platform</title>
    <style>
        /* Reset some default styles */
        body, h1, p, a {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Basic styling */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            padding: 20px;
        }

        .content {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 40px;
            max-width: 500px;
            width: 100%;
            text-align: center;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
            font-size: 2.5em;
            font-weight: 700;
        }

        p {
            color: #555;
            margin-bottom: 30px;
            font-size: 1.2em;
        }

        .button-container {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .btn {
            display: inline-block;
            padding: 15px 30px;
            font-size: 1.1em;
            text-decoration: none;
            border-radius: 8px;
            color: #fff;
            transition: background-color 0.3s ease, transform 0.2s ease;
            font-weight: 600;
        }

        .btn-login {
            background-color: #007bff;
        }

        .btn-login:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }

        .btn-register {
            background-color: #28a745;
        }

        .btn-register:hover {
            background-color: #218838;
            transform: translateY(-2px);
        }

        .btn-admin {
            background-color: #dc3545;
        }

        .btn-admin:hover {
            background-color: #c82333;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="content">
            <div class="button-container">
                <a href="{{ route('login') }}" class="btn btn-login">Login</a>
                <a href="{{ route('register') }}" class="btn btn-register">Register</a>
                <a href="{{ route('admin.generate.url') }}" class="btn btn-admin">Admin</a>
            </div>
        </div>
    </div>
</body>
</html>
