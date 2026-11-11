@extends('layouts.app')

@section('title', 'Products List')

@section('content')

    <h2>Products List</h2>

    @can('create', \App\Models\Product::class)
        <a href="{{ route('products.create') }}" class="btn add-product-btn">
            Add New Product
        </a>
    @endcan

    <br><br>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Status</th>
                <th>Expiry Date</th>
                <th>Supplier</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>

                    <td>{{ $product->quantity }}</td>

                    <td>
                        {{ number_format((float) $product->price, 2) }}
                    </td>

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
                        {{ $product->supplier?->name ?? 'N/A' }}
                    </td>

                    <td>
                        <a
                            href="{{ route('products.show', $product) }}"
                            class="btn show-detail-btn"
                        >
                            Show Details
                        </a>
                    </td>
                </tr>

            @empty
                <tr>
                    <td colspan="7" class="text-center">
                        No products found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>


    <div class="back-button">
        <a href="{{ route('categories.index') }}" class="btn">
            Show Categories
        </a>

        <a href="{{ route('suppliers.index') }}" class="btn">
            Show Suppliers
        </a>

        @can('viewNotifications', \App\Models\User::class)
            <a href="{{ route('notifications.index') }}" class="btn">
                Show Notifications
            </a>
        @endcan

        <a href="{{ route('stock-movements.index') }}" class="btn">
            Show Stock Movements
        </a>
    </div>
@endsection
