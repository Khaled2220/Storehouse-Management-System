@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')

<h2 class="text-center">Edit Profile</h2>

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

    @if (session('status') === 'Profile-Updated-Successfully')
        <div class="alert alert-success">
            Profile updated successfully.
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="form-group">
            <label for="full_name">Full Name:</label>

            <input
                type="text"
                name="full_name"
                id="full_name"
                class="form-control"
                value="{{ old('full_name', $user->full_name) }}"
                autocomplete="name"
                required>

            @error('full_name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email:</label>

            <input
                type="email"
                name="email"
                id="email"
                class="form-control"
                value="{{ old('email', $user->email) }}"
                autocomplete="email"
                required>

            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-update">
                Update Profile
            </button>

            <a href="{{ route('profile') }}" class="btn btn-back">
                Back
            </a>
        </div>
    </form>

</div>

@endsection
