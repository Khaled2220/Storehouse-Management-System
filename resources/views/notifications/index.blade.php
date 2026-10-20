<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Notifications</title>

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f5f5f5;
        }

        .navbar .nav-link,
        .navbar .nav-link:hover,
        .navbar .nav-link:focus,
        .navbar .nav-link.active {
            color: black !important;
            font-size: 20px;
        }

        .notification {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
        }

        .unread {
            border-left: 5px solid #2563eb;
        }

        .read {
            border-left: 5px solid #16a34a;
        }

        .success {
            color: green;
            margin-bottom: 15px;
        }

        button {
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            cursor: pointer;
        }
    </style>
</head>

<body>

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
            <a class="nav-link active" href="{{ route('notifications.index') }}">
                My Notifications

                @auth
                    @php
                        $unreadCount = auth()->user()
                            ->unreadNotifications()
                            ->count();
                    @endphp

                    @if ($unreadCount > 0)
                        <span class="badge badge-light">
                            {{ $unreadCount }}
                        </span>
                    @endif
                @endauth
            </a>
        </li>
    </ul>
</nav>

<br>

<div class="container">

    <h1>My Notifications</h1>

    @if (session('success'))
        <p class="success">{{ session('success') }}</p>
    @endif

    @forelse ($notifications as $notification)

        <div class="notification {{ $notification->read_at ? 'read' : 'unread' }}">

            <h3>
                {{ $notification->data['message'] ?? 'New notification' }}
            </h3>

            {{-- Product notification details --}}
            @if (isset($notification->data['product_name']))
                <p>
                    <strong>Product:</strong>
                    {{ $notification->data['product_name'] }}
                </p>
            @endif

            @if (isset($notification->data['product_id']))
                <p>
                    <strong>Product ID:</strong>
                    {{ $notification->data['product_id'] }}
                </p>
            @endif

            {{-- Category notification details --}}
            @if (isset($notification->data['category_name']))
                <p>
                    <strong>Category:</strong>
                    {{ $notification->data['category_name'] }}
                </p>
            @endif

            @if (isset($notification->data['category_id']))
                <p>
                    <strong>Category ID:</strong>
                    {{ $notification->data['category_id'] }}
                </p>
            @endif

            <p>
                <strong>Date:</strong>
                {{ $notification->created_at->format('Y-m-d H:i') }}
            </p>

            <p>
                <strong>Status:</strong>
                {{ $notification->read_at ? 'Read' : 'Unread' }}
            </p>

            @unless ($notification->read_at)
                <form method="POST"
                      action="{{ route('notifications.read', $notification->id) }}">
                    @csrf
                    @method('PATCH')

                    <button type="submit">Mark as read</button>
                </form>
            @endunless

        </div>

    @empty
        <p>You have no notifications.</p>
    @endforelse

    {{ $notifications->links() }}

</div>

</body>
</html>
