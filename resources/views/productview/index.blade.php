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

    @if (auth()->check() && auth()->user()->user_type === 1)
        <a href="{{ route('Products.create') }}">
            <button type="button" class="btn btn-success">
                Add New Products
            </button>
        </a>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Image</th>
                <th>Date</th>

                @if (auth()->check() && auth()->user()->user_type === 1)
                    <th>Action</th>
                @endif
            </tr>
        </thead>

        <tbody>
            @foreach ($Products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>{{ $product->price }}</td>

                    <td>
                        @if ($product->image)
                            <img
                                src="{{ asset('image/' . $product->image) }}"
                                width="80"
                                style="border-radius: 4px; display: block;"
                                alt="{{ $product->name }}"
                            >
                        @endif
                    </td>

                    <td>{{ $product->created_at->format('Y-m-d') }}</td>

                    @if (auth()->check() && auth()->user()->user_type === 1)
                        <td>
                            <a
                                href="{{ url('/Products/' . $product->id . '/edit') }}"
                                style="text-decoration: none; margin-right: 5px;"
                            >
                                <button type="button" class="btn btn-secondary btn-sm">
                                    Edit
                                </button>
                            </a>

                            <form
                                action="{{ url('/Products/' . $product->id) }}"
                                method="POST"
                                style="display: inline;"
                                onsubmit="return confirm('Are you sure?')"
                            >
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger btn-sm">
                                    <span class="glyphicon glyphicon-trash"></span>
                                    Delete
                                </button>
                            </form>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
