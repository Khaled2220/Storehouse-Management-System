@extends('layouts.app')

@section('title', 'Products List')

@section('content')

    <h2>Products List</h2>

    @can('create', \App\Models\Product::class)
        <a href="{{ route('products.create') }}" class="btn add-product-btn">
            Add New Products
        </a>
    @endcan

    <br><br>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Status</th>
                <th>Expiry Date</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>

                    <td>
                        @if ($product->status === 'expired')
                            <span class="label label-danger">Expired</span>
                        @else
                            <span class="label label-success">Active</span>
                        @endif
                    </td>

                    <td>
                        {{ $product->expiry_date?->format('Y-m-d') ?? 'Not specified' }}
                    </td>

                    <td>
                        <a href="{{ route('products.show', $product) }}"
                           class="btn show-detail-btn">
                            Show Detail
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">
                        No products found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if (method_exists($products, 'links'))
        {{ $products->links() }}
    @endif

    <div class="back-button">
        <a href="{{ route('categories.index') }}" class="btn">
            Show Categories
        </a>

        <a href="{{ route('suppliers.index') }}" class="btn">
            Show Suppliers
        </a>

        @can('viewNotifications', \App\Models\User::class)
        <a href="{{ route('notifications.index') }}" class="btn">
            Show Notification
        </a>
        @endcan
    </div>

@endsection
