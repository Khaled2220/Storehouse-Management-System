@extends('layouts.app')

@section('title', 'Suppliers List')

@section('content')

    <h2>Suppliers List</h2>

    @can('create', \App\Models\Supplier::class)
        <a href="{{ route('suppliers.create') }}" class="btn add-product-btn">
            Add New Supplier
        </a>
    @endcan

    <br><br>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Logo</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Products Count</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($suppliers as $supplier)
                <tr>
                    <td>
                        @if ($supplier->logo)
                            <img src="{{ asset('storage/' . $supplier->logo) }}" alt="{{ $supplier->name }} Logo" width="60"
                                height="60"
                                style="object-fit: contain;"
                            >
                        @else
                            No Logo
                        @endif
                    </td>

                    <td>{{ $supplier->name }}</td>

                    <td>{{ $supplier->contact_email ?? 'Not specified' }}</td>

                    <td>{{ $supplier->phone ?? 'Not specified' }}</td>

                    <td>{{ $supplier->products_count }}</td>

                    <td>
                        <a href="{{ route('suppliers.show', $supplier) }}" class="btn show-detail-btn">
                            Show Detail
                        </a>

                        @can('update', $supplier)
                            <a href="{{ route('suppliers.edit', $supplier) }}" class="btn edit-btn">
                                Edit
                            </a>
                        @endcan

                        @can('delete', $supplier)
                            <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this supplier?');" >
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn delete-btn">
                                    Delete
                                </button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">
                        No suppliers found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if (method_exists($suppliers, 'links'))
        {{ $suppliers->links() }}
    @endif

    <div class="back-button">
        <a href="{{ route('products.index') }}" class="btn">
            Show list products
        </a>

        <a href="{{ route('categories.index') }}" class="btn">
            Show Categories
        </a>

        @can('viewNotifications', \App\Models\User::class)
            <a href="{{ route('notifications.index') }}" class="btn">
                Show Notification
                @if (($unreadNotificationsCount ?? 0) > 0)
                    ({{ $unreadNotificationsCount }})
                @endif
            </a>
        @endcan
    </div>
@endsection
