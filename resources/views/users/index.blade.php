@extends('layouts.app')

@section('title', 'Users List')

@section('content')

<h2>Users List</h2>

@can('create', \App\Models\User::class)
    <div class="add-button">
        <a href="{{ route('users.create') }}" class="btn add-btn">
            Add User
        </a>
    </div>
@endcan

<div class="table-responsive">
    <table class="table table-bordered table-striped">

        <thead>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>User Type</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>

                    <td>{{ $user->full_name }}</td>

                    <td>{{ $user->email }}</td>

                    <td>{{ $user->isAdmin() ? 'Admin' : 'User' }}</td>

                    <td>{{ $user->created_at?->format('Y-m-d') }}</td>

                    <td>
                        <div class="action-buttons">

                            @can('view', $user)
                                <a href="{{ route('users.show', $user) }}" class="btn show-products-btn">
                                    Show
                                </a>
                            @endcan

                            @can('update', $user)
                                <a href="{{ route('users.edit', $user) }}" class="btn edit-btn">
                                    Edit
                                </a>
                            @endcan

                            @can('delete', $user)
                                <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn delete-btn">
                                        Delete
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </td>
                </tr>

            @empty
                <tr>
                    <td colspan="6" class="text-center">
                        No Users Found
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="text-center">
    {{ $users->links() }}
</div>

<div class="back-button">
    <a href="{{ route('products.index') }}" class="btn back-btn">
        Back to Products
    </a>
</div>
@endsection
