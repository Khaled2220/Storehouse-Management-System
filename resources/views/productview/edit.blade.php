<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Edit Product</title>

    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
        }
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
        .current-image {
            max-width: 250px;
            height: auto;
            border-radius: 6px;
            margin-top: 10px;
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
        .update-btn {
            background-color: #5cb85c;
            border-color: #4cae4c;
            color: white;
        }
        .update-btn:hover,
        .update-btn:focus {
            background-color: #449d44;
            border-color: #398439;
            color: white;
        }
        .back-button {
            margin-top: 15px;
        }
        .back-button .back-btn,
        .unauthorized-back-btn {
            width: 170px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-sizing: border-box;
            font-size: 14px;
            background-color: DimGrey;
            color: white !important;
            border: none;
            border-radius: 4px;
            text-decoration: none;
        }
        .back-button .back-btn:hover,
        .back-button .back-btn:focus,
        .unauthorized-back-btn:hover,
        .unauthorized-back-btn:focus {
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

            
            @if (auth()->check() && (int) auth()->user()->user_type === 1)
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('notifications.index') }}">
                        My Notifications

                        @php
                            $unreadCount = auth()->user()
                                ->unreadNotifications()
                                ->count();
                        @endphp

                        @if ($unreadCount > 0)
                            <span class="badge">
                                {{ $unreadCount }}
                            </span>
                        @endif
                    </a>
                </li>
            @endif
        </ul>
    </nav>

    <div class="container">
        <h2>Edit Product</h2>

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
                action="{{ route('Products.update', $product->id) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control"
                        value="{{ old('name', $product->name) }}"
                        required>
                </div>

                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea
                        id="description"
                        name="description"
                        class="form-control"
                        rows="4">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="quantity">Quantity:</label>
                    <input
                        type="number"
                        id="quantity"
                        name="quantity"
                        class="form-control"
                        value="{{ old('quantity', $product->quantity) }}"
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
                        value="{{ old('price', $product->price) }}"
                        min="0"
                        step="0.01"
                        required>
                </div>

                <div class="form-group">
                    <label>Current Image:</label>
                    <br>
                    @if ($product->image)
                        <img
                            src="{{ asset('image/' . $product->image) }}"
                            class="current-image"
                            alt="{{ $product->name }}">
                    @else
                        <p>No image available.</p>
                    @endif
                </div>

                <div class="form-group">
                    <label for="image">Change Image:</label>
                    <input
                        type="file"
                        id="image"
                        name="image"
                        class="form-control"
                        accept="image/jpeg,image/png,image/jpg,image/gif">
                </div>

                <div class="action-buttons">
                    <button type="submit" class="btn update-btn">
                        Update Product
                    </button>
                </div>
            </form>

            <div class="back-button">
                <a href="{{ route('Products.index') }}"
                   class="btn back-btn">
                    Back to Products
                </a>
            </div>

        @else
            <div class="alert alert-danger">
                <h4>Unauthorized access! Admin only.</h4>
                <p>You do not have permission to edit products.</p>

                <a href="{{ route('Products.index') }}"
                   class="btn unauthorized-back-btn">
                    Back to Products
                </a>
            </div>
        @endif
    </div>