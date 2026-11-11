@extends('layouts.app')

@section('title', 'Stock Movements')

@section('content')

<h2>Stock Movements</h2>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@can('create', App\Models\StockMovement::class)

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Record New Stock Movement</h4>
        </div>

        <div class="panel-body">
            <form action="{{ route('stock-movements.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">

                            <label for="product_id">Product</label>

                            <select name="product_id" id="product_id" class="form-control" required>
                                <option value="">Select Product</option>

                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                        (Available: {{ $product->quantity }})
                                    </option>
                                @endforeach
                            </select>

                            @error('product_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="type">Movement Type</label>

                            <select name="type" id="type" class="form-control" required>
                                <option value="">Select Type</option>

                                <option value="in" {{ old('type') === 'in' ? 'selected' : '' }}>
                                    Stock In
                                </option>

                                <option value="out" {{ old('type') === 'out' ? 'selected' : '' }}>
                                    Stock Out
                                </option>
                            </select>

                            @error('type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">

                            <label for="quantity">Quantity</label>

                            <input type="number" name="quantity" id="quantity" class="form-control" min="1" step="1" value="{{ old('quantity') }}" required>

                            @error('quantity')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="movement_date">Movement Date</label>

                            <input type="date" name="movement_date" id="movement_date" class="form-control" value="{{ old('movement_date', now()->toDateString()) }}" required>

                            @error('movement_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

         
                <div class="form-group">
                    <label for="supplier_id">Supplier</label>

                    <select name="supplier_id" id="supplier_id" class="form-control">

                        <option value="">Select Supplier</option>

                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->name }}
                            </option>
                        @endforeach
                    </select>

                    <p class="help-block">
                        Supplier is required for Stock In movements.
                    </p>

                    @error('supplier_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                
                <div class="form-group">
                    <label for="note">Note (Optional)</label>

                    <textarea name="note" id="note" class="form-control" rows="3">
                        {{ old('note') }}
                    </textarea>

                    @error('note')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="attachment">Attachment (Optional)</label>

                    <input type="file" name="attachment" id="attachment" class="form-control" accept=".pdf,.jpg,.jpeg,.png">

                    <p class="help-block">
                        Allowed formats: PDF, JPG, JPEG, PNG.
                        Maximum size: 5 MB.
                    </p>

                    @error('attachment')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success">
                    Record Movement
                </button>
            </form>
        </div>
    </div>
@endcan

<hr>

<h3>Filter Stock Movements</h3>

<form action="{{ route('stock-movements.index') }}" method="GET">
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">

                <label for="filter_product_id">Product</label>

                <select name="product_id" id="filter_product_id" class="form-control">

                    <option value="">All Products</option>

                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" {{ ($filters['product_id'] ?? '') == $product->id ? 'selected' : '' }}>
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">

                <label for="filter_type">Movement Type</label>

                <select name="type" id="filter_type" class="form-control">

                    <option value="">All Types</option>

                    <option value="in" {{ ($filters['type'] ?? '') === 'in' ? 'selected' : '' }}>
                        Stock In
                    </option>

                    <option value="out" {{ ($filters['type'] ?? '') === 'out' ? 'selected' : '' }}>
                        Stock Out
                    </option>
                </select>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">

                <label for="date_from">Date From</label>

                <input type="date" name="date_from" id="date_from" class="form-control" value="{{ $filters['date_from'] ?? '' }}">
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">

                <label for="date_to">Date To</label>

                <input type="date" name="date_to" id="date_to" class="form-control" value="{{ $filters['date_to'] ?? '' }}">
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-default">
        Apply Filters
    </button>

    <a href="{{ route('stock-movements.index') }}" class="btn btn-default">
        Clear Filters
    </a>
</form>

<hr>

<h3>Movement History</h3>

@if ($movements->isEmpty())
    <p>No stock movements found.</p>

@else
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Type</th>
                    <th>Quantity</th>
                    <th>Date</th>
                    <th>Supplier</th>
                    <th>Note</th>
                    <th>Attachment</th>
                    <th>Recorded By</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($movements as $movement)
                    <tr>
                        <td>
                            {{ $movement->product?->name ?? 'N/A' }}
                        </td>


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

                        <td>
                            {{ $movement->quantity }}
                        </td>

                        <td>
                            {{ $movement->movement_date?->format('Y-m-d') }}
                        </td>

                        <td>
                            {{ $movement->supplier?->name ?? 'N/A' }}
                        </td>

                        <td>
                            {{ $movement->note ?? 'N/A' }}
                        </td>

                        <td>
                            @if ($movement->attachment)
                                <a href="{{ asset('storage/' . $movement->attachment) }}" target="_blank" rel="noopener noreferrer">
                                    View Attachment
                                </a>

                            @else
                                N/A
                            @endif
                        </td>

                        <td>
                            {{ $movement->creator?->full_name ?? 'N/A' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="pagination-container">
        {{ $movements->links() }}
    </div>
@endif

<div class="back-button">
    <a href="{{ route('products.index') }}" class="btn back-btn">
        Back to Products
    </a>
</div>
@endsection
