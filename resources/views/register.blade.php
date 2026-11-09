@extends('layouts.app')

@section('title', 'Register')

@section('content')

    <div class="register-page">

        <div class="panel register-box">
            <div class="panel-body">

                <h2 class="text-center text-logo">
                    Storehouse Management System
                </h2>

                <br>

                <form method="POST" action="{{ route('register.store') }}">
                    @csrf

                    <div class="form-group">
                        <label for="full_name">Full Name</label>

                        <input
                            type="text"
                            class="form-control"
                            id="full_name"
                            name="full_name"
                            value="{{ old('full_name') }}"
                            required
                        >

                        @error('full_name')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>

                        <input
                            type="email"
                            class="form-control"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                        >

                        @error('email')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>

                        <input
                            type="password"
                            class="form-control"
                            id="password"
                            name="password"
                            minlength="6"
                            maxlength="20"
                            required
                        >

                        @error('password')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>

                    <button
                        type="submit"
                        class="btn btn-register btn-block"
                    >
                        Create Account
                    </button>

                    <p class="text-center" style="margin-top: 15px; margin-bottom: 0;">
                        Already have an account?

                        <a href="{{ route('login') }}">
                            Login
                        </a>
                    </p>

                </form>

            </div>
        </div>

    </div>

@endsection
