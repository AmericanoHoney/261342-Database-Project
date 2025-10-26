<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link href="https://fonts.googleapis.com/css2?family=Inria+Serif:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html, body {
            height: 100%; width: 100%;
            font-family: 'Inria Serif', serif;
            background: url('{{ asset('images/background.png') }}') no-repeat center center;
            background-size: cover;
        }

        .signup-container {
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            width: 880px;
            height: 640px;
            display: flex;
        }

        .signup-left {
            flex: 0.6;
            background: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .signup-left h1 { 
            font-size: 36px; 
            margin-bottom: 20px; 
        }

        .signup-left form { 
            width: 90%; 
            display: flex; 
            flex-direction: column; 
        }

        .form-row {
            display: flex;
            gap: 10px;
        }

        .form-row input {
            flex: 1;
        }

        .signup-left label { 
            font-size: 16px; 
            margin-bottom: 5px; 
            color: #110f0fff; 
            display: block;
        }

        .signup-left input { 
            padding: 8px; 
            margin-bottom: 15px; 
            border: 1px solid #ccc; 
            border-radius: 5px; 
            font-size: 14px; 
            width: 100%;
        }

        .signup-left button { 
            padding: 10px; 
            background-color: #DABAC9; 
            border: none; 
            border-radius: 25px; 
            font-size: 18px; 
            font-family: 'Inria Serif', serif;
            cursor: pointer; 
            margin-top: 15px; 
        }

        .signup-left button:hover { 
            background-color: #DABAC9;
        }

        .error-message { 
            color: red; 
            font-size: 14px; 
            margin-top: 5px; 
            min-height: 20px; 
        }

        .login-link { 
            margin-top: 15px; 
            font-size: 14px;
        }

        .login-link a { 
            color: #B6487B; 
            text-decoration: none; 
            font-weight: bold; 
        }

        .login-link a:hover { 
            text-decoration: underline; 
        }

        .signup-right {
            flex: 0.4;
            background: url('{{ asset('images/box-signup-right.png') }}') no-repeat center center;
            background-size: cover;
        }

    </style>
</head>
<body>
    <div class="signup-container">
        <div class="signup-left">
            <h1>Sign Up</h1>
            <form method="POST" action="{{ route('signup') }}">
                @csrf

                <div class="form-row">
                    <div style="flex:1">
                        <label for="first_name">First Name</label>
                        <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}">
                        @error('first_name')<div class="error-message">{{ $message }}</div>@enderror
                    </div>
                    <div style="flex:1">
                        <label for="last_name">Last Name</label>
                        <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}">
                        @error('last_name')<div class="error-message">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-row">
                    <div style="flex:1">
                        <label for="birthdate">Birthdate</label>
                        <input type="date" id="birthdate" name="birthdate" value="{{ old('birthdate') }}">
                        @error('birthdate')<div class="error-message">{{ $message }}</div>@enderror
                    </div>
                    <div style="flex:1">
                        <label for="phone">Phone Number</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone') }}">
                        @error('phone')<div class="error-message">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div>
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" value="{{ old('address') }}">
                    @error('address')<div class="error-message">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}">
                    @error('email')<div class="error-message">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password">
                    @error('password')<div class="error-message">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation">
                </div>
                
                <button type="submit">sign up</button>
            </form>

            <div class="login-link">
                Already have an account? <a href="{{ route('login') }}">Log In</a>
            </div>
        </div>
        <div class="signup-right"></div>
    </div>
</body>
</html>
