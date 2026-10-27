<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Products List</title>

    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <style>
        .navbar .nav-link,
        .navbar .nav-link:hover,
        .navbar .nav-link:focus,
        .navbar .nav-link.active {
            color: black !important;
            font-size: 20px;
        }
        .container {
            margin-top: 20px;
            margin-bottom: 30px;
        }
        .show-detail-btn {
            background-color: DimGrey;
            color: white !important;
            border: none;
            border-radius: 4px;
            text-decoration: none;
        }
        .show-detail-btn:hover,
        .show-detail-btn:focus {
            background-color: #555555;
            color: white !important;
            text-decoration: none;
        }
        .add-product-btn {
            background-color: #5cb85c;
            border-color: #4cae4c;
            color: white !important;
        }
        .add-product-btn:hover,
        .add-product-btn:focus {
            background-color: #449d44;
            border-color: #398439;
            color: white !important;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-sm bg-primary navbar-dark">
        <ul class="nav navbar-nav">
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('Products.index') }}">
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
        <h2>Products List</h2>

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

        @if (auth()->check() && (int) auth()->user()->user_type === 1)
            <a href="{{ route('Products.create') }}"
               class="btn add-product-btn">
                Add New Products
            </a>
        @endif

        <br><br>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($Products as $product)
                    <tr>
                        <td>
                            {{ $product->name }}
                        </td>

                        <td>
                            <a href="{{ route('Products.show', $product->id) }}"
                               class="btn show-detail-btn">
                                Show Detail
                            </a>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="2" class="text-center">
                            No products found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if (method_exists($Products, 'links'))
            {{ $Products->links() }}
        @endif
    </div>
