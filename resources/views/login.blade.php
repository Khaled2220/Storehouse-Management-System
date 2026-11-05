<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login</title>

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <style>
        body {
            background-color: #f4f6f9;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: system-ui, -apple-system, sans-serif;
        }
        .login-box {
            width: 100%;
            max-width: 440px;
            background-color: #ffffff;
            border: none;
            border-radius: 6px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        .text-logo {
            font-size: 2.2rem;
            font-weight: 700;
            color: #0b4d7a;
            letter-spacing: -1px;
        }
        .login-box .form-control {
            border: 1px solid #cbd5e1;
            padding: 10px 14px;
            border-radius: 6px;
        }
        .login-box .form-control:focus {
            border-color: #0b4d7a;
            box-shadow: 0 0 0 2px rgba(11, 77, 122, 0.15);
        }
        .btn-login {
            background-color: Navy;
            color: #ffffff;
            font-weight: 600;
            padding: 11px;
            border-radius: 6px;
            border: none;
        }
        .btn-login:hover {
            background-color: #083b5e;
            color: #ffffff;
        }
    </style>
</head>

<body>
<div class="container d-flex justify-content-center">
    <div class="card login-box">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('login.store') }}">
                @csrf
                <h2 class="text-center mb-4 text-logo">Login</h2>

                <div class="form-group">
                    <label for="email">Email:</label>

                    <input type="email" class="form-control"id="email" name="email" value="{{ old('email') }}"  requiredautofocus >

                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>

                    <input type="password" class="form-control" id="password" name="password" required>

                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="remember" id="rememberMe" value="1" {{ old('remember') ? 'checked' : '' }}>

                    <label class="form-check-label ml-2" for="rememberMe">
                        Remember me
                    </label>
                </div>

                <button type="submit" class="btn btn-login btn-block">
                    Login
                </button>

                <p class="text-center mt-3 mb-0">
                    <span class="text-muted small">
                        Don't have an account?
                    </span>

                    <a href="{{ route('register') }}"
                       class="btn btn-sm text-white font-weight-bold ml-1 px-3"
                       style="background-color: Navy;">
                        Create Account
                    </a>
                </p>
            </form>
        </div>
    </div>
</div>
