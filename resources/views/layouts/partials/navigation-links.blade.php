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
                    Categories
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

            @if (auth()->user()?->isAdmin())
            <li>
                <a class="nav-link" href="{{ route('suppliers.index') }}">
                    Suppliers
                </a>
            </li>

            <li>
                <a class="nav-link" href="{{ route('stock-movements.index') }}">
                    Stock Movements
                </a>
            </li>
            @endif

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
