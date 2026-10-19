<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Notifications</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #f5f5f5;
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

    <h1>My Notifications</h1>

    @if (session('success'))
        <p class="success">{{ session('success') }}</p>
    @endif

    @forelse ($notifications as $notification)
        <div class="notification {{ $notification->read_at ? 'read' : 'unread' }}">

            <h3>
                {{ $notification->data['message'] ?? 'New notification' }}
            </h3>

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

</body>
</html>

