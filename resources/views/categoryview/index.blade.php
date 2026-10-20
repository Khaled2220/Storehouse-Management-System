<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Categories List</title>

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

        .action-buttons {
            display: flex;
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
            align-items: center;
            justify-content: center;
            box-sizing: border-box;
            font-size: 14px;
        }

        .action-buttons form {
            display: inline-block;
            margin: 0;
        }

        .add-button {
            margin-bottom: 20px;
        }

        .back-button {
            margin-top: 20px;
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

        .table th,
        .table td {
            vertical-align: middle !important;
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

    @if (auth()->check() && (int) auth()->user()->user_type === 1)
        <div class="add-button">
            <a href="{{ route('Categorios.create') }}" class="btn btn-success">
                Add New Category
            </a>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Name</th>

                    @if (auth()->check() && (int) auth()->user()->user_type === 1)
                        <th>Action</th>
                    @endif
                </tr>
            </thead>

            <tbody>
                @forelse ($categorios as $category)
                    <tr>
                        <td>{{ $category->name }}</td>

                        @if (auth()->check() && (int) auth()->user()->user_type === 1)
                            <td>
                                <div class="action-buttons">
                                    <a
                                        href="{{ route('Categorios.edit', $category->id) }}"
                                        class="btn btn-warning"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('Categorios.destroy', $category->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this category?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger">
                                            <span class="glyphicon glyphicon-trash"></span>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td
                            colspan="{{ auth()->check() && (int) auth()->user()->user_type === 1 ? 2 : 1 }}"
                            class="text-center"
                        >
                            No categories found.
                        </td>
                    </tr>
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