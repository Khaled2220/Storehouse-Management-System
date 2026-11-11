@extends('layouts.app')

@section('title', 'Add User')

@section('content')

    <h2 class="text-center">Add New User</h2>

    <div class="form-container">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @can('create', \App\Models\User::class)

            <form action="{{ route('users.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="full_name">Full Name:</label>

                    <input type="text" name="full_name" id="full_name" class="form-control" value="{{ old('full_name') }}" placeholder="Enter full name"
                        maxlength="250"
                        required
                    >

                    @error('full_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>

                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" placeholder="Enter email" maxlength="225" required >

                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>

                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" minlength="7" required >

                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="user_type">User Type:</label>

                    <select name="user_type" id="user_type" class="form-control" required >
                        <option value="">Select User Type</option>

                        <option value="1" {{ old('user_type') === '1' ? 'selected' : '' }}>
                            Admin
                        </option>

                        <option value="2" {{ old('user_type') === '2' ? 'selected' : '' }}>
                            User
                        </option>
                    </select>

                    @error('user_type')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-add">
                        Add User
                    </button>

                    <a href="{{ route('users.index') }}" class="btn btn-back">
                        Back
                    </a>
                </div>
            </form>

        @else

            <div class="alert alert-danger">
                You are not authorized to create users.
            </div>

            <a href="{{ route('users.index') }}" class="btn btn-back">
                Back
            </a>
        @endcan
    </div>
@endsection
