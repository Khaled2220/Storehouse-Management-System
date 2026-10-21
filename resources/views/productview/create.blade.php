<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Add New Product</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <style>
        .navbar .nav-link,
        .navbar .nav-link:hover,
        .navbar .nav-link:focus,
        .navbar .nav-link.active {
            color: black !important;
            font-size: 20px;
        }

        .container {
            margin-top: 25px;
            margin-bottom: 30px;
        }

        .product-form {
            max-width: 600px;
        }

        .form-control {
            width: 100%;
            max-width: 600px;
        }

        .action-buttons {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .action-buttons .btn,
        .back-button .btn {
            width: 170px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-sizing: border-box;
            font-size: 14px;
        }

        .back-button {
            margin-top: 15px;
        }

        /* Back button only */
        .back-button .back-btn {
            background-color: DimGrey;
            color: white !important;
            border: none;
            border-radius: 4px;
            text-decoration: none;
        }

        .back-button .back-btn:hover,
        .back-button .back-btn:focus {
            background-color: #555555;
            color: white !important;
            text-decoration: none;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-sm bg-primary navbar-dark">
    <ul class="nav navbar-nav">
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
                        <span class="badge">{{ $unreadCount }}</span>
                    @endif
                @endauth
            </a>
        </li>
    </ul>
</nav>

<div class="container">

    <h2>Add New Product</h2>

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

    @if (auth()->check() && (int) auth()->user()->user_type === 1)

        <form
            class="product-form"
            method="POST"
            action="{{ route('Products.store') }}"
            enctype="multipart/form-data"
        >
            @csrf

            <div class="form-group">
                <label for="name">Name:</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    class="form-control"
                    value="{{ old('name') }}"
                    required
                >
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea
                    id="description"
                    name="description"
                    class="form-control"
                    rows="4"
                >{{ old('description') }}</textarea>
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
                    required
                >
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
                    required
                >
            </div>

            <div class="form-group">
                <label for="image">Image:</label>
                <input
                    type="file"
                    id="image"
                    name="image"
                    class="form-control"
                    accept="image/jpeg,image/png,image/jpg,image/gif"
                >
            </div>

            <div class="action-buttons">
                <button type="submit" class="btn btn-success">
                    Save Product
                </button>
            </div>

        </form>

        <div class="back-button">
            <a href="{{ route('Products.index') }}" class="btn back-btn">
                Back to Products
            </a>
        </div>

    @else

        <div class="alert alert-danger">
            <h4>Unauthorized access! Admin only.</h4>
            <p>You do not have permission to add products.</p>

            <div class="back-button">
                <a href="{{ route('Products.index') }}" class="btn back-btn">
                    Back to Products
                </a>
            </div>
        </div>
    @endif
</div>