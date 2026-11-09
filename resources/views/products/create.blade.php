@extends('layouts.app')

@section('title', 'Add New Product')

@section('content')

<h2>Add New Product</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@can('create', \App\Models\Product::class)

    <form class="product-form"
          method="POST"
          action="{{ route('products.store') }}"
          enctype="multipart/form-data">

        @csrf

        <div class="form-group">
            <label for="name">Name:</label>
            <input
                type="text"
                id="name"
                name="name"
                class="form-control"
                value="{{ old('name') }}"
                required>
        </div>

        <div class="form-group">
            <label for="categories">Categories:</label>

            <select name="categories[]" id="categories" class="form-control" multiple>
                @foreach ($categories as $category)
                    <option
                        value="{{ $category->id }}"
                        {{ in_array($category->id, old('categories', [])) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <small class="text-muted">
                Hold Ctrl to select multiple categories.
            </small>
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea
                id="description"
                name="description"
                class="form-control"
                rows="4">{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="quantity">Quantity:</label>
            <input
                type="number"
                id="quantity"
                name="quantity"
                class="form-control"
                value="{{ old('quantity') }}"
                min="0"
                required>
        </div>

        <div class="form-group">
            <label for="price">Price:</label>
            <input
                type="number"
                id="price"
                name="price"
                class="form-control"
                value="{{ old('price') }}"
                min="0"
                step="0.01"
                required>
        </div>

        <div class="form-group">
            <label for="image">Image:</label>
            <input
                type="file"
                id="image"
                name="image"
                class="form-control"
                accept="image/jpeg,image/png,image/jpg,image/gif">
        </div>

        <div class="form-group">
            <label for="status">Status:</label>

            <select name="status" id="status" class="form-control" required>
                <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>
                    Active
                </option>

                <option value="expired" {{ old('status') == 'expired' ? 'selected' : '' }}>
                    Expired
                </option>
            </select>
        </div>

        <div class="form-group">
            <label for="expiry_date">Expiry Date:</label>
            <input
                type="date"
                id="expiry_date"
                name="expiry_date"
                class="form-control"
                value="{{ old('expiry_date') }}">
        </div>

        <div class="action-buttons">
            <button type="submit" class="btn save-btn">
                Save Product
            </button>
        </div>

    </form>

@else

    <div class="alert alert-danger">
        <h4>Unauthorized access!</h4>
        <p>You do not have permission to add products.</p>
    </div>

@endcan

<div class="back-button">
    <a href="{{ route('products.index') }}" class="btn back-btn">
        Back to Products
    </a>
</div>

@endsection
