@extends('layouts.app')

@section('title', 'Add New Supplier')

@section('content')

    <h2>Add New Supplier</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @can('create', \App\Models\Supplier::class)

        <form class="product-form"
              method="POST"
              action="{{ route('suppliers.store') }}"
              enctype="multipart/form-data">

            @csrf

            <div class="form-group">
                <label for="name">Supplier Name:</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    class="form-control"
                    value="{{ old('name') }}"
                    maxlength="255"
                    required>
            </div>

            <div class="form-group">
                <label for="contact_email">Contact Email:</label>
                <input
                    type="email"
                    id="contact_email"
                    name="contact_email"
                    class="form-control"
                    value="{{ old('contact_email') }}">
            </div>

            <div class="form-group">
                <label for="phone">Phone:</label>
                <input
                    type="text"
                    id="phone"
                    name="phone"
                    class="form-control"
                    value="{{ old('phone') }}"
                    maxlength="30">
            </div>

            <div class="form-group">
                <label for="address">Address:</label>
                <textarea
                    id="address"
                    name="address"
                    class="form-control"
                    rows="4">{{ old('address') }}</textarea>
            </div>

            <div class="form-group">
                <label for="logo">Supplier Logo:</label>
                <input
                    type="file"
                    id="logo"
                    name="logo"
                    class="form-control"
                    accept="image/jpeg,image/png,image/jpg,image/gif">

                <small class="text-muted">
                    Optional. Allowed formats: JPEG, PNG, JPG, GIF. Maximum size: 2MB.
                </small>
            </div>

            <div class="action-buttons">
                <button type="submit" class="btn save-btn">
                    Save Supplier
                </button>
            </div>

        </form>

    @else

        <div class="alert alert-danger">
            <h4>Unauthorized access!</h4>
            <p>You do not have permission to add suppliers.</p>
        </div>

    @endcan

    <div class="back-button">
        <a href="{{ route('suppliers.index') }}" class="btn back-btn">
            Back to Suppliers
        </a>
    </div>

@endsection
