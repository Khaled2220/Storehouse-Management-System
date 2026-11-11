@extends('layouts.app')

@section('title', 'Product Details')

@section('content')

    <h2>Product Details</h2>

    <table class="table table-bordered product-details">
        <tbody>
            <tr>
                <th>Name</th>
                <td>{{ $product->name }}</td>
            </tr>

            <tr>
                <th>Categories</th>
                <td>
                    @forelse ($product->categories as $category)
                        <span>{{ $category->name }}</span>{{ !$loop->last ? ', ' : '' }}
                    @empty
                        No categories assigned
                    @endforelse
                </td>
            </tr>

            <tr>
                <th>Supplier</th>
                <td>
                    @if ($product->supplier)
                        <a href="{{ route('suppliers.show', $product->supplier) }}">
                            {{ $product->supplier->name }}
                        </a>
                    @else
                        No supplier assigned
                    @endif
                </td>
            </tr>

            <tr>
                <th>Description</th>
                <td>
                    {{ $product->description ?? 'No description available' }}
                </td>
            </tr>

            <tr>
                <th>Quantity</th>
                <td>{{ $product->quantity }}</td>
            </tr>

            <tr>
                <th>Price</th>
                <td>{{ number_format((float) $product->price, 2) }}</td>
            </tr>

            <tr>
                <th>Status</th>
                <td>
                    @if ($product->status === 'expired')
                        <span class="label label-danger">Expired</span>
                    @else
                        <span class="label label-success">Active</span>
                    @endif
                </td>
            </tr>

            <tr>
                <th>Expiry Date</th>
                <td>
                    {{ $product->expiry_date?->format('Y-m-d') ?? 'Not specified' }}
                </td>
            </tr>

            <tr>
                <th>Image</th>
                <td>
                    @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="product-image" alt="{{ $product->name }}" >
                    @else
                        No image available
                    @endif
                </td>
            </tr>

            <tr>
                <th>Date Created</th>
                <td>
                    {{ $product->created_at?->format('Y-m-d') ?? 'N/A' }}
                </td>
            </tr>
        </tbody>
    </table>

    <hr>

    <h3>Stock Movement History</h3>

    @if ($movements->isEmpty())
        <p>No stock movements recorded for this product.</p>
    @else
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Quantity</th>
                    <th>Date</th>
                    <th>Supplier</th>
                    <th>Note</th>
                    <th>Recorded By</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($movements as $movement)
                    <tr>
                        <td>
                            @if ($movement->type === 'in')
                                <span class="label label-success">
                                    Stock In
                                </span>
                            @else
                                <span class="label label-danger">
                                    Stock Out
                                </span>
                            @endif
                        </td>

                        <td>{{ $movement->quantity }}</td>

                        <td>
                            {{ $movement->movement_date?->format('Y-m-d') ?? 'N/A' }}
                        </td>

                        <td>
                            {{ $movement->supplier?->name ?? 'N/A' }}
                        </td>

                        <td>
                            {{ $movement->note ?? 'N/A' }}
                        </td>

                        <td>
                            {{ $movement->creator?->full_name ?? 'N/A' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $movements->links() }}
    @endif

    <div class="action-buttons">
        @can('update', $product)
            <a href="{{ route('products.edit', $product) }}" class="btn edit-btn">
                Edit
            </a>
        @endcan

        @can('delete', $product)
            <form action="{{ route('products.destroy', $product) }}" method="POST"
                onsubmit="return confirm('Are you sure you want to delete this product?')"
            >
                @csrf
                @method('DELETE')

                <button type="submit" class="btn delete-btn">
                    <span class="glyphicon glyphicon-trash"></span>
                    Delete
                </button>
            </form>
        @endcan
    </div>

    <div class="back-button">
        <a href="{{ route('products.index') }}" class="btn back-btn">
            Back to Products
        </a>
    </div>
@endsection
