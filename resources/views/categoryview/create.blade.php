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

    @if (auth()->check() && auth()->user()->user_type === 1)

        <h2>Add New Category</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('Categorios.store') }}">
            @csrf

            <label for="name">Name:</label><br>

            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
                required
            >

            <br><br>

            <button
                type="submit"
                class="btn btn-success"
                style="background-color: OliveDrab; color: white;"
            >
                Save Category
            </button>
        </form>

        <br>

        <a
            href="{{ route('Categorios.index') }}"
            style="background-color: DimGrey; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px; font-weight: bold;"
        >
            Back
        </a>

    @else

        <div class="alert alert-danger" style="margin-top: 20px;">
            <h4>Unauthorized access! Admin only.</h4>
            <p>Redirecting you back to the categories list...</p>
        </div>

        <script>
            setTimeout(function () {
                window.location.href = "{{ route('Categorios.index') }}";
            }, 2000);
        </script>

    @endif

</div>
