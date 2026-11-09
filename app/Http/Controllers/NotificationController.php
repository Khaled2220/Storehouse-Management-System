<?php

namespace App\Http\Controllers;

use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function __construct(private NotificationService $notificationService)
    {
        //
    }

    /**
     * Display notifications for the authenticated user.
     */
    public function index(Request $request)
    {
        $notifications = $this->notificationService
            ->getUserNotifications($request->user());

        return view('notifications.index')
            ->with('notifications', $notifications);
    }

    public function markAsRead(
        Request $request,
        DatabaseNotification $notification
    ) {
        $this->notificationService->markAsRead(
            $request->user(),
            $notification->id
        );

        return redirect()->route('notifications.index')
            ->with('success', 'Notification marked as Read.');
    }

    public function destroy(Request $request, DatabaseNotification $notification)
    {
        $this->notificationService->deleteNotification(
            $request->user(),
            $notification->id
        );

        return redirect()->route('notifications.index')
            ->with('success', 'Notification deleted successfully.');
    }
}
