@extends('layouts.app')

@section('title', 'Edit User')

@section('content')

    <h2 class="text-center">Edit User</h2>

    @php
        $selectedUserType = (string) old(
            'user_type',
            $user->user_type->value
        );
    @endphp

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

        @can('update', $user)

            <form action="{{ route('users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="full_name">Full Name:</label>

                    <input type="text" name="full_name" id="full_name" class="form-control" value="{{ old('full_name', $user->full_name) }}" maxlength="250" required >

                    @error('full_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>

                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" maxlength="225" required >

                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>

                    <input type="password" name="password" id="password" class="form-control" placeholder="Leave empty to keep current password" minlength="7" autocomplete="new-password" >

                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="user_type">User Type:</label>

                    <select name="user_type" id="user_type" class="form-control" required >
                        <option value="1" {{ $selectedUserType === '1' ? 'selected' : '' }}>
                            Admin
                        </option>

                        <option value="2" {{ $selectedUserType === '2' ? 'selected' : '' }}>
                            User
                        </option>
                    </select>

                    @error('user_type')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-update">
                        Update User
                    </button>

                    <a href="{{ route('users.index') }}" class="btn btn-back">
                        Back
                    </a>
                </div>
            </form>

        @else

            <div class="alert alert-danger">
                You are not authorized to update this user.
            </div>

            <a href="{{ route('users.index') }}" class="btn btn-back">
                Back
            </a>

        @endcan

    </div>
@endsection
