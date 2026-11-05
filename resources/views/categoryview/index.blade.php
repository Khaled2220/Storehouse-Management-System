<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Categories List</title>

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
        .category-form {
            max-width: 600px;
        }
        .form-control {
            width: 100%;
            max-width: 600px;
        }
        h2 {
            margin-bottom: 25px;
        }
        .table {
            background-color: white;
        }
        .table th,
        .table td {
            text-align: center;
            vertical-align: middle !important;
        }
        .action-buttons {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }
        .action-buttons .btn,
        .add-button .btn,
        .back-button .btn {
            width: 170px;
            height: 40px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            font-size: 14px;
            border-radius: 4px;
            border: none;
            text-decoration: none;
        }
        .show-products-btn,
        .back-btn {
            background-color: DimGrey;
            color: white;
        }
        .show-products-btn:hover,
        .back-btn:hover {
            background-color: #555555;
            color: white;
        }
        .edit-btn {
            background-color: #f0ad4e;
            color: white;
        }
        .edit-btn:hover {
            background-color: #ec971f;
            color: white;
        }
        .delete-btn {
            background-color: #d9534f;
            color: white;
        }
        .delete-btn:hover {
            background-color: #c9302c;
            color: white;
        }
        .add-btn {
            background-color: #5cb85c;
            color: white;
        }
        .add-btn:hover {
            background-color: #449d44;
            color: white;
        }
        .alert {
            margin-top: 15px;
        }
        .back-button {
            margin-top: 20px;
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


            @can('viewNotifications', \App\Models\User::class)
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('notifications.index') }}">
                        My Notifications
                        @if (($unreadNotificationsCount ?? 0) > 0)
                            <span class="badge">
                                {{ $unreadNotificationsCount }}
                            </span>
                        @endif
                    </a>
                </li>
            @endcan

            <li class="nav-item">
                <a class="nav-link" href="{{ route('profile') }}">
                    My Profile
                </a>
            </li>
        </ul>

        <form method="POST" action="{{ route('logout') }}"class="navbar-form navbar-right">
            @csrf
            <button type="submit" class="btn btn-default">
                Logout
            </button>
        </form>
    </nav>

    <div class="container">
        <h2>Categories List</h2>

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


        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        @can('create', \App\Models\Categorios::class)
            <div class="add-button" style="margin-bottom: 20px;">
                <a href="{{ route('Categorios.create') }}" class="btn add-btn">
                    Add New Category
                </a>
            </div>
        @endcan


        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Category Name</th>
                        <th>Show Products</th>
                        @can('create', \App\Models\Categorios::class)
                            <th>Action</th>
                        @endcan
                    </tr>
                </thead>

                <tbody>
                    @forelse ($categorios as $category)
                        <tr>
                            <td>
                                {{ $category->id }}
                            </td>

                            <td>
                                {{ $category->name }}
                            </td>

                            <td>
                                <a href="{{ route('Products.index', ['category_id' => $category->id]) }}" class="btn show-products-btn">
                                    Show Products
                                </a>
                            </td>

                            @can('create', \App\Models\Categorios::class)
                                <td>
                                    <div class="action-buttons">
                                        @can('update', $category)
                                            <a href="{{ route('Categorios.edit', $category->id) }}" class="btn edit-btn">
                                                Edit
                                            </a>
                                        @endcan

                                        @can('delete', $category)
                                            <form action="{{ route('Categorios.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn delete-btn">
                                                    Delete
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            @endcan
                        </tr>

                    @empty
                        @can('create', \App\Models\Categorios::class)
                            <tr>
                                <td colspan="4" class="text-center">
                                    No categories found.
                                </td>
                            </tr>

                        @else
                            <tr>
                                <td colspan="3" class="text-center">
                                    No categories found.
                                </td>
                            </tr>
                        @endcan
                    @endforelse
                </tbody>
            </table>
        </div>


        <div class="back-button">
            <a href="{{ route('Products.index') }}" class="btn back-btn">
                Back to Products
            </a>
        </div>
    </div>
