<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Inria+Serif:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html, body {
            height: 100%; width: 100%;
            font-family: 'Inria Serif', serif;
            background: url('{{ asset('images/background.png') }}') no-repeat center center;
            background-size: cover;
        }
        .login-container {
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            width: 818px; height: 560px;
            display: flex;
            box-shadow: 0 0 15px rgba(0,0,0,0);
        }
        .login-left {
            flex: 0.4;
            background: url('{{ asset('images/box-login-left.png') }}') no-repeat center center;
            background-size: cover;
        }
        .login-right {
            flex: 0.6;
            background: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .login-right h1 { 
            font-size: 42px; 
            margin-top: 60px; 
            margin-bottom: 25px; 
        }
        .login-right form { 
            width: 70%; 
            display: flex; 
            flex-direction: column; 
        }
        .login-right label { 
            font-size: 20px; 
            margin-bottom: 10px; 
            color: #110f0fff; 
        }
        .login-right input { 
            padding: 8px; 
            margin-bottom: 30px; 
            border: 1px solid #ccc; 
            border-radius: 5px; 
            font-size: 18px; 
        }
        .login-right button { 
            padding: 10px; 
            background-color: #DABAC9; 
            border: none; 
            border-radius: 25px; 
            font-size: 20px; 
            font-family: 'Inria Serif', serif;
            cursor: pointer; 
            margin-top: 20px; 
        }
        .login-right button:hover { 
            background-color: #DABAC9; 
        }
        .error-message { 
            color: red; 
            font-size: 16px; 
            margin-top: 15px; 
            min-height: 24px; 
        }
        .signup-link { 
            margin-top: 60px; 
            font-size: 18px;
        }
        .signup-link a { 
            color: #B6487B; 
            text-decoration: none; 
            font-weight: bold; 
        }
        .signup-link a:hover { 
            text-decoration: underline; 
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-left"></div>
        <div class="login-right">
            <h1>Log In</h1>
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <label for="email">Email</label>
                <input type="text" id="email" name="email" value="{{ old('email') }}">
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror

                <label for="password">Password</label>
                <input type="password" id="password" name="password">
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror

                @if(session('error'))
                    <div class="error-message">{{ session('error') }}</div>
                @endif

                <button type="submit">log in</button>
            </form>

            <div class="signup-link">
                Don’t have account? <a href="{{ route('signup') }}">Sign up</a>
            </div>
        </div>
    </div>
</body>
</html>
