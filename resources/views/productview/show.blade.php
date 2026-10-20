<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Product Details</title>

    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

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

        .product-image {
            max-width: 250px;
            height: auto;
            border-radius: 6px;
            margin-top: 10px;
        }

        .product-details th {
            width: 180px;
        }

        /* Same size for all buttons */
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

        /* Back button on a separate row */
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

    {{-- Navigation Bar --}}
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
                            $unreadCount = auth()->user()
                                ->unreadNotifications()
                                ->count();
                        @endphp

                        @if ($unreadCount > 0)
                            <span class="badge">{{ $unreadCount }}</span>
                        @endif
                    @endauth
                </a>
            </li>

        </ul>
    </nav>

    {{-- Product Details --}}
    <div class="container">

        <h2>Product Details</h2>

        {{-- Success Message --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Error Message --}}
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        {{-- Product Information --}}
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

        {{-- Update and Delete Buttons --}}
        <div class="action-buttons">

            @if (auth()->check() && (int) auth()->user()->user_type === 1)

                {{-- Update Button --}}
                <a href="{{ route('Products.edit', $product->id) }}"
                   class="btn btn-warning">
                    Update
                </a>

                {{-- Delete Button --}}
                <form
                    action="{{ route('Products.destroy', $product->id) }}"
                    method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this product?')"
                >
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">
                        Delete
                    </button>
                </form>

            @endif

        </div>

        {{-- Back Button: Separate Row --}}
        <div class="back-button">
            <a href="{{ route('Products.index') }}"
               class="btn back-btn">
                Back to Products
            </a>
        </div>

    </div>