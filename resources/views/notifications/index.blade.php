@extends('layouts.app')

@section('title', 'My Notifications')

@section('content')

<h1>My Notifications</h1>

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
                    action="{{ route('notifications.read', $notification) }}">

                    @csrf
                    @method('PATCH')

                    <button type="submit" class="mark-read-button">
                        Mark as read
                    </button>
                </form>
            @endunless

            <form
                action="{{ route('notifications.destroy', $notification) }}"
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
    <a href="{{ route('products.index') }}" class="btn back-btn">
        Back to Products
    </a>

    <a href="{{ route('categories.index') }}" class="btn back-btn">
        Back to Categories
    </a>
</div>

@endsection
