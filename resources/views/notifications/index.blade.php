<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Notifications</title>

    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

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
        .container {
            margin-top: 20px;
            margin-bottom: 30px;
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
        .notification-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
            margin-top: 15px;
        }
        .notification-actions form {
            display: inline-block;
            margin: 0;
        }
        .notification-actions .btn {
            min-width: 100px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-sizing: border-box;
            font-size: 14px;
        }
        .mark-read-button {
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px 15px;
            cursor: pointer;
            min-width: 100px;
            height: 40px;
            font-size: 14px;
        }
        .mark-read-button:hover {
            background: #1d4ed8;
            color: white;
        }
        .notification-actions .btn-danger {
            background-color: #d9534f;
            border-color: #d43f3a;
            color: white;
        }
        .notification-actions .btn-danger:hover,
        .notification-actions .btn-danger:focus {
            background-color: #c9302c;
            border-color: #ac2925;
            color: white;
        }
        .back-buttons {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 20px;
            margin-bottom: 25px;
        }
        .back-btn {
            width: 170px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-sizing: border-box;
            font-size: 14px;
            background-color: DimGrey;
            color: white !important;
            border: none;
            border-radius: 4px;
            text-decoration: none;
        }
        .back-btn:hover,
        .back-btn:focus {
            background-color: #555555;
            color: white !important;
            text-decoration: none;
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
                <a class="nav-link active"
                   href="{{ route('notifications.index') }}">
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
    <h1>My Notifications</h1>

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

    @forelse ($notifications as $notification)
        <div class="notification {{ $notification->read_at ? 'read' : 'unread' }}">
            <h3>
                {{ $notification->data['message'] ?? 'New notification' }}
            </h3>

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

            <div class="notification-actions">
                @unless ($notification->read_at)
                    <form
                        method="POST"
                        action="{{ route('notifications.read', $notification->id) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="mark-read-button">
                            Mark as read
                        </button>
                    </form>
                @endunless


                <form
                    action="{{ route('notifications.destroy', $notification->id) }}"
                    method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this notification?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <span class="glyphicon glyphicon-trash"></span>
                        Delete
                    </button>
                </form>
            </div>
        </div>

    @empty
        <div class="alert alert-info">
            You have no notifications.
        </div>
    @endforelse


    <div class="mt-3">
        {{ $notifications->links() }}
    </div>


    <div class="back-buttons">
        <a href="{{ route('Products.index') }}" class="btn back-btn">
            Back to Products
        </a>

        <a href="{{ route('Categorios.index') }}" class="btn back-btn">
            Back to Categories
        </a>
    </div>
</div>