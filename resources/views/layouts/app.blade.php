<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Storehouse Management System')</title>

    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body>
    @if (auth()->check() && !request()->routeIs('login', 'register'))
        <nav class="navbar navbar-default">
            <div class="container-fluid">

                <ul class="nav navbar-nav">
                    <li>
                        <a class="nav-link" href="{{ route('products.index') }}">
                            Products
                        </a>
                    </li>

                    <li>
                        <a class="nav-link" href="{{ route('categories.index') }}">
                            Category
                        </a>
                    </li>

                    @can('viewNotifications', \App\Models\User::class)
                        <li>
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

                    <li>
                        <a class="nav-link" href="{{ route('profile') }}">
                            My Profile
                        </a>
                    </li>
                </ul>

                <form method="POST" action="{{ route('logout') }}" class="navbar-form navbar-right">
                    @csrf

                    <button type="submit" class="btn btn-default">
                        Logout
                    </button>
                </form>
            </div>
        </nav>
    @endif

    <div class="container">

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

        @yield('content')
    </div>
    @stack('scripts')
</body>
</html>