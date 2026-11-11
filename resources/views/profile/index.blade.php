@extends('layouts.app')

@section('title', 'My Profile')

@section('content')

<div class="profile-container">

    <h2 class="profile-title">My Profile</h2>

    @if (session('status') === 'Profile-Updated-Successfully')
        <div class="alert alert-success">
            Profile updated successfully.
        </div>
    @endif

    <div class="profile-row">

        <div class="profile-label">
            Full Name
        </div>
        
        <div>
            {{ $user->full_name }}
        </div>

        <br>

        <div class="profile-label">
            Email
        </div>

        <div>
            {{ $user->email }}
        </div>

        <br>

        <div class="profile-label">
            User Type
        </div>

        <div>
            {{ $user->isAdmin() ? 'Admin' : 'User' }}
        </div>
    </div>

    <a href="{{ route('profile.edit') }}" class="btn edit-button">
        Edit Profile
    </a>

    <a href="{{ route('products.index') }}" class="btn profile-back-button">
        Back
    </a>

    <hr>

    <h4>Delete Account</h4>

    <p class="text-danger">
        Warning: Deleting your account is permanent.
    </p>

    <form action="{{ route('profile.destroy') }}" method="POST" class="delete-form" onsubmit="return confirm('Are you sure you want to delete your account?')">
        @csrf
        @method('DELETE')

        <div class="form-group">
            <label for="password">Enter Your Current Password</label>

            <input type="password" name="password" id="password" class="form-control" placeholder="Current Password" autocomplete="current-password" required>

            @error('password', 'userDeletion')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>

        <button type="submit" class="btn delete-button">
            <span class="glyphicon glyphicon-trash"></span>
            Delete Account
        </button>
    </form>
</div>
@endsection
