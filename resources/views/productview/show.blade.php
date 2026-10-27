<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Product Details</title>

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
        .product-image {
            max-width: 250px;
            height: auto;
            border-radius: 6px;
            margin-top: 10px;
        }
        .product-details th {
            width: 180px;
        }
        .action-buttons .btn,
        .back-button .btn {
            width: 150px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-sizing: border-box;
            font-size: 14px;
        }
        .action-buttons {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }
        .action-buttons form {
            display: inline-block;
            margin: 0;
        }
        .back-button {
            margin-top: 15px;
        }
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
        .edit-btn {
            background-color: #f0ad4e;
            border-color: #eea236;
            color: white;
        }
        .edit-btn:hover,
        .edit-btn:focus {
            background-color: #ec971f;
            border-color: #d58512;
            color: white;
        }
        .delete-btn {
            background-color: #d9534f;
            border-color: #d43f3a;
            color: white;
        }
        .delete-btn:hover,
        .delete-btn:focus {
            background-color: #c9302c;
            border-color: #ac2925;
            color: white;
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
        <h2>Product Details</h2>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <table class="table table-bordered product-details">
            <tbody>
                <tr>
                    <th>Name</th>
                    <td>{{ $product->name }}</td>
                </tr>

                <tr>
                    <th>Description</th>
                    <td>
                        {{ $product->description ?? 'No description available' }}
                    </td>
                </tr>

                <tr>
                    <th>Quantity</th>
                    <td>{{ $product->quantity }}</td>
                </tr>

                <tr>
                    <th>Price</th>
                    <td>{{ $product->price }}</td>
                </tr>

                <tr>
                    <th>Image</th>
                    <td>
                        @if ($product->image)
                            <img
                                src="{{ asset('image/' . $product->image) }}"
                                class="product-image"
                                alt="{{ $product->name }}"
                            >
                        @else
                            No image available
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>Date Created</th>
                    <td>
                        {{ $product->created_at?->format('Y-m-d') ?? 'N/A' }}
                    </td>
                </tr>
            </tbody>
        </table>

    
        @if (auth()->check() && (int) auth()->user()->user_type === 1)
            <div class="action-buttons">
                <a href="{{ route('Products.edit', $product->id) }}"
                   class="btn edit-btn">
                    Edit
                </a>

                <form
                    action="{{ route('Products.destroy', $product->id) }}"
                    method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this product?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn delete-btn">
                        <span class="glyphicon glyphicon-trash"></span>
                        Delete
                    </button>
                </form>
            </div>
        @endif

        <div class="back-button">
            <a href="{{ route('Products.index') }}"
               class="btn back-btn">
                Back to Products
            </a>
        </div>
    </div>
