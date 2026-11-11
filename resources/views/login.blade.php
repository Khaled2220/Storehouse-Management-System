@extends('layouts.app')

@section('title', 'Login')

@section('content')

    <div class="login-page">
        <div class="panel login-box">
            <div class="panel-body">
                <form method="POST" action="{{ route('login.store') }}">
                    @csrf

                    <h2 class="text-center text-logo">
                        Login
                    </h2>
                    <br>

                    <div class="form-group">
                        <label for="email">Email:</label>

                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus >

                        @error('email')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password:</label>

                        <input type="password" class="form-control" id="password" name="password" required >

                        @error('password')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>

                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember" id="rememberMe" value="1" {{ old('remember') ? 'checked' : '' }} >
                            Remember me
                        </label>
                    </div>

                    <button type="submit" class="btn btn-login btn-block" >
                        Login
                    </button>

                    <p class="text-center" style="margin-top: 15px;">
                        <span class="text-muted">
                            Don't have an account?
                        </span>

                        <a href="{{ route('register') }}" class="btn btn-sm btn-create-account" >
                            Create Account
                        </a>

                    </p>
                </form>
            </div>
        </div>
    </div>
@endsection
