@extends('layouts.app')

@section('title', 'Supplier Details')

@section('content')

<h2>Supplier Details</h2>

<table class="table table-bordered product-details">
    <tbody>
        <tr>
            <th>Name</th>
            <td>{{ $supplier->name }}</td>
        </tr>

        <tr>
            <th>Contact Email</th>
            <td>{{ $supplier->contact_email ?? 'Not specified' }}</td>
        </tr>

        <tr>
            <th>Phone</th>
            <td>{{ $supplier->phone ?? 'Not specified' }}</td>
        </tr>

        <tr>
            <th>Address</th>
            <td>{{ $supplier->address ?? 'Not specified' }}</td>
        </tr>

        <tr>
            <th>Logo</th>
            <td>
                @if ($supplier->logo)
                    <img
                        src="{{ asset('storage/' . $supplier->logo) }}"
                        alt="{{ $supplier->name }} Logo"
                        width="150"
                        height="150"
                        style="object-fit: contain;">
                @else
                    No logo available
                @endif
            </td>
        </tr>

        <tr>
            <th>Date Created</th>
            <td>
                {{ $supplier->created_at?->format('Y-m-d') ?? 'N/A' }}
            </td>
        </tr>
    </tbody>
</table>

<h3>Supplier Products</h3>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($supplier->products as $product)
            <tr>
                <td>{{ $product->name }}</td>

                <td>{{ $product->quantity }}</td>

                <td>{{ $product->price }}</td>

                <td>{{ $product->status }}</td>

                <td>
                    <a href="{{ route('products.show', $product) }}"
                       class="btn show-detail-btn">
                        Show Product
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">
                    No products are associated with this supplier.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="action-buttons">

    @can('update', $supplier)
        <a href="{{ route('suppliers.edit', $supplier) }}" class="btn edit-btn">
            Edit
        </a>
    @endcan

    @can('delete', $supplier)
        @if ($supplier->products->isEmpty())
            <form
                action="{{ route('suppliers.destroy', $supplier) }}"
                method="POST"
                onsubmit="return confirm('Are you sure you want to delete this supplier?')">

                @csrf
                @method('DELETE')

                <button type="submit" class="btn delete-btn">
                    <span class="glyphicon glyphicon-trash"></span>
                    Delete
                </button>
            </form>
        @endif
    @endcan

</div>

<div class="back-button">
    <a href="{{ route('suppliers.index') }}" class="btn back-btn">
        Back to Suppliers
    </a>
</div>

@endsection
