<?php

namespace App\Http\Controllers;

use App\Services\NotificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function __construct(private NotificationService $notificationService)
    {
        //
    }

    /**
     * Display notifications for the authenticated user.
     */
    public function index(Request $request): View
    {
        $notifications = $this->notificationService->getUserNotifications($request->user());

        return view('notifications.index')->with('notifications', $notifications);
    }

    public function markAsRead(Request $request, DatabaseNotification $notification): RedirectResponse
    {
        $this->notificationService->markAsRead($request->user(), $notification->id);

        return redirect()->route('notifications.index')
            ->with('success', 'Notification marked as Read.');
    }

    public function destroy(Request $request, DatabaseNotification $notification): RedirectResponse
    {
        $this->notificationService->deleteNotification($request->user(), $notification->id);

        return redirect()->route('notifications.index')
            ->with('success', 'Notification deleted successfully.');
    }
}
