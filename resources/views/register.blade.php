<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Register</title>

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
        .register-box {
            width: 100%;
            max-width: 440px;
            background-color: #ffffff;
            border-radius: 6px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        .text-logo {
            font-size: 1.8rem;
            font-weight: 700;
            color: #0b4d7a;
        }
        .form-control {
            border: 1px solid #cbd5e1;
            padding: 10px 14px;
            border-radius: 6px;
        }
        .btn-register {
            background-color: Navy;
            color: white;
            font-weight: 600;
            padding: 11px;
            border-radius: 6px;
            border: none;
        }
        .btn-register:hover {
            background-color: #083b5e;
            color: white;
        }
    </style>
</head>

<body>
<div class="container d-flex justify-content-center">
    <div class="card register-box">
        <div class="card-body p-4">

            <h2 class="text-center text-logo mb-4">
                Storehouse Management System
            </h2>

            <form method="POST" action="{{ route('register.store') }}">
                @csrf

                <div class="form-group">
                    <label for="full_name">Full Name</label>

                    <input type="text" class="form-control" id="full_name" name="full_name" value="{{ old('full_name') }}" required>

                    @error('full_name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>

                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>

                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>

                    <input type="password" class="form-control" id="password" name="password" minlength="6" maxlength="20" required>

                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit"
                        class="btn btn-register btn-block">
                    Create Account
                </button>

                <p class="text-center mt-3 mb-0">
                    Already have an account?

                    <a href="{{ route('login') }}">
                        Login
                    </a>
                </p>
            </form>
        </div>
    </div>
</div>
