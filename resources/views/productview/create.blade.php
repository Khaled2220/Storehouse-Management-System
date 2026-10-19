<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .navbar .nav-link,
        .navbar .nav-link:hover,
        .navbar .nav-link:focus,
        .navbar .nav-link.active {
            color: black !important;
            font-size: 20px;
        }
    </style>
</head>

<nav class="navbar navbar-expand-sm bg-primary navbar-dark">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('Products.index') }}">
                Products
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('Categorios.index') }}">
                Category
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('notifications.index') }}">
                My Notifications

                @auth
                    @php
                        $unreadCount = auth()->user()->unreadNotifications()->count();
                    @endphp

                    @if ($unreadCount > 0)
                        <span class="badge badge-light">{{ $unreadCount }}</span>
                    @endif
                @endauth
            </a>
        </li>
    </ul>
</nav>

<br>

<div class="container">

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

    <form
        method="POST"
        action="{{ route('Products.store') }}"
        enctype="multipart/form-data"
    >
        @csrf

        <label>Name</label><br>
        <input
            type="text"
            name="name"
            value="{{ old('name') }}"
            required
        >
        <br><br>

        <label>Description</label><br>
        <textarea name="description">{{ old('description') }}</textarea>
        <br><br>

        <label>Quantity</label><br>
        <input
            type="number"
            name="quantity"
            value="{{ old('quantity') }}"
            min="0"
            required
        >
        <br><br>

        <label>Price</label><br>
        <input
            type="number"
            name="price"
            value="{{ old('price') }}"
            min="0"
            step="0.01"
            required
        >
        <br><br>

        <label>Image</label><br>
        <input
            type="file"
            name="image"
            accept="image/jpeg,image/png,image/jpg,image/gif"
        >
        <br><br>

        <button
            type="submit"
            class="btn btn-sm text-white font-weight-bold shadow-sm"
            style="background-color: green; padding: 6px 12px; font-size: 13px;"
        >
            Save Product
        </button>
    </form>

    <br>

    <a
        href="{{ route('Products.index') }}"
        style="background-color: DimGrey; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px; font-weight: bold;"
    >
        Back
    </a>

</div>
