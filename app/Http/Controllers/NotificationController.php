<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NotificationService;
use App\Models\User;

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
        $notifications = $this->notificationService->getUserNotifications($request->user());

        return view('notifications.index')->with('notifications', $notifications);

        //return view('notifications.index', compact('notifications'));
    }

    /**
     * Mark a notification as read.
     */
    public function markAsRead(Request $request, string $id)
    {
       $this->notificationService->markAsRead($request->user(),$id);

        return redirect()->route('notifications.index')
            ->with('success', 'Notification marked as Read.');
    }

    /**
     * Delete a notification belonging to the authenticated user.
     */
    public function destroy(Request $request, string $id)
    {
        $this->notificationService->deleteNotification($request->user(),$id);

        return redirect()->route('notifications.index')
            ->with('success', 'Notification deleted successfully.');
    }
}
