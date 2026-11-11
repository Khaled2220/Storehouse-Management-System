@extends('layouts.app')

@section('title', 'User Details')

@section('content')

<h2 class="text-center">User Details</h2>

<table class="table table-bordered details">

    <tr>
        <th>ID</th>
        <td>{{ $user->id }}</td>
    </tr>

    <tr>
        <th>Full Name</th>
        <td>{{ $user->full_name }}</td>
    </tr>

    <tr>
        <th>Email</th>
        <td>{{ $user->email }}</td>
    </tr>

    <tr>
        <th>User Type</th>
        <td>{{ $user->isAdmin() ? 'Admin' : 'User' }}</td>
    </tr>

    <tr>
        <th>Created At</th>
        <td>{{ $user->created_at?->format('Y-m-d H:i:s') }}</td>
    </tr>

    <tr>
        <th>Updated At</th>
        <td>{{ $user->updated_at?->format('Y-m-d H:i:s') }}</td>
    </tr>
</table>

<div class="text-center">
    <a href="{{ route('users.index') }}" class="btn btn-back">
        Back
    </a>
</div>
@endsection
