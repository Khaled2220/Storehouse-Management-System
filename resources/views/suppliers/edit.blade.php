@extends('layouts.app')

@section('title', 'Edit Supplier')

@section('content')

<h2>Edit Supplier</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@can('update', $supplier)

    <form class="product-form"
          method="POST"
          action="{{ route('suppliers.update', $supplier) }}"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Supplier Name:</label>

            <input
                type="text"
                id="name"
                name="name"
                class="form-control"
                value="{{ old('name', $supplier->name) }}"
                maxlength="255"
                required>

            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="contact_email">Contact Email:</label>

            <input
                type="email"
                id="contact_email"
                name="contact_email"
                class="form-control"
                value="{{ old('contact_email', $supplier->contact_email) }}">

            @error('contact_email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="phone">Phone:</label>

            <input
                type="text"
                id="phone"
                name="phone"
                class="form-control"
                value="{{ old('phone', $supplier->phone) }}"
                maxlength="30">

            @error('phone')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="address">Address:</label>

            <textarea
                id="address"
                name="address"
                class="form-control"
                rows="4">{{ old('address', $supplier->address) }}</textarea>

            @error('address')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label>Current Logo:</label>
            <br>

            @if ($supplier->logo)
                <img
                    src="{{ asset('storage/' . $supplier->logo) }}"
                    class="current-image"
                    alt="{{ $supplier->name }} Logo"
                    width="150"
                    height="150"
                    style="object-fit: contain;">
            @else
                <p>No logo available.</p>
            @endif
        </div>

        <div class="form-group">
            <label for="logo">Change Logo:</label>

            <input
                type="file"
                id="logo"
                name="logo"
                class="form-control"
                accept="image/jpeg,image/png,image/jpg,image/gif">

            <small class="text-muted">
                Leave empty to keep the current logo.
                Maximum size: 2MB.
            </small>

            @error('logo')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="action-buttons">
            <button type="submit" class="btn update-btn">
                Update Supplier
            </button>
        </div>

    </form>

@else

    <div class="alert alert-danger">
        <h4>Unauthorized access!</h4>
        <p>You do not have permission to edit suppliers.</p>
    </div>

@endcan

<div class="back-button">
    <a href="{{ route('suppliers.index') }}" class="btn back-btn">
        Back to Suppliers
    </a>
</div>

@endsection
