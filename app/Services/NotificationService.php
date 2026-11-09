<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class NotificationService
{
    /**
     * Get notifications for a user.
     */
    public function getUserNotifications(User $user): LengthAwarePaginator
    {
        return $user->notifications()
            ->latest()
            ->paginate(10);
    }

    /**
     * Mark a user's notification as read.
     */
    public function markAsRead(User $user, string $id): void
    {
        $notification = $user->notifications()
            ->whereKey($id)
            ->firstOrFail();

        $notification->markAsRead();
    }

    /**
     * Delete a user's notification.
     */
    public function deleteNotification(User $user, string $id): void
    {
        $notification = $user->notifications()
            ->whereKey($id)
            ->firstOrFail();

        $notification->delete();
    }

    public function getUnreadCount(User $user): int
    {
        return $user->unreadNotifications()->count();
    }
}
