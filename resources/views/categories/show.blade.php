@extends('layouts.app')

@section('title', 'Category Products')

@section('content')

<h2>Category: {{ $category->name }}</h2>
<h3>Products List</h3>

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Image</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($category->products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>{{ $product->price }}</td>

                    <td>
                        @if ($product->image)
                            <img
                                src="{{ asset('storage/' . $product->image) }}"
                                alt="{{ $product->name }}"
                                class="product-image">
                        @else
                            No Image
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">
                        No products found in this category.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="back-button">
    <a href="{{ route('categories.index') }}" class="btn back-btn">
        Back to Categories
    </a>
</div>

@endsection
