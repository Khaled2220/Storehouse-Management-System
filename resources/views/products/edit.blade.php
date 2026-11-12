@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')

    <h2>Edit Product</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @can('update', $product)

        <form class="product-form" method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Name:</label>

                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>

                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="categories">Categories:</label>

                <select name="categories[]" id="categories" class="form-control" multiple>

                    @php
                        $selectedCategories = old(
                            'categories',
                            $product->categories->pluck('id')->toArray()
                        );
                    @endphp

                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ in_array($category->id, $selectedCategories) ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach

                </select>

                <small class="text-muted">
                    Hold Ctrl to select multiple categories.
                </small>

                @error('categories')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

                @error('categories.*')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="supplier_id">Supplier:</label>

                <select name="supplier_id" id="supplier_id" class="form-control" required>

                    <option value="">Select Supplier</option>

                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}"
                            {{ old('supplier_id', $product->supplier_id) == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->name }}
                        </option>
                    @endforeach
                </select>

                @error('supplier_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description:</label>

                <textarea id="description" name="description" class="form-control" rows="4">
                          {{ old('description', $product->description) }}
                </textarea>

                @error('description')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="quantity">Quantity:</label>

                <input type="number" id="quantity" name="quantity" class="form-control" value="{{ old('quantity', $product->quantity) }}" min="0" required>

                @error('quantity')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="price">Price:</label>

                <input type="number" id="price" name="price" class="form-control" value="{{ old('price', $product->price) }}" min="0" step="0.01" required>

                @error('price')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="status">Status:</label>

                <select name="status" id="status" class="form-control" required>

                    <option value="active"
                        {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>
                        Active
                    </option>

                    <option value="expired"
                        {{ old('status', $product->status) == 'expired' ? 'selected' : '' }}>
                        Expired
                    </option>

                </select>

                @error('status')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="expiry_date">Expiry Date:</label>

                <input type="date" id="expiry_date" name="expiry_date" class="form-control" value="{{ old('expiry_date', $product->expiry_date?->format('Y-m-d')) }}">

                @error('expiry_date')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Current Image:</label>
                <br>

                @if ($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="current-image" alt="{{ $product->name }}">
                @else
                    <p>No image available.</p>
                @endif
            </div>

            <div class="form-group">
                <label for="image">Change Image:</label>

                <input type="file" id="image" name="image" class="form-control" accept="image/jpeg,image/png,image/jpg,image/gif">

                @error('image')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="action-buttons">
                <button type="submit" class="btn update-btn">
                    Update Product
                </button>
            </div>
        </form>

    @else

        <div class="alert alert-danger">
            <h4>Unauthorized access!</h4>
            <p>You do not have permission to edit products.</p>
        </div>

    @endcan

    <div class="back-button">
        <a href="{{ route('products.index') }}" class="btn back-btn">
            Back to list Products
        </a>
    </div>
@endsection
