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
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>

                    <td>
                        <a href="{{ route('products.show', $product) }}" class="btn show-detail-btn" >
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
@include('layouts.partials.body')
@endsection
