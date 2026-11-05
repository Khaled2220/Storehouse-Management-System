<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class CategoryCreatedNotification extends Notification
{
    /**
     * Create a new notification instance.
     */
    public function __construct(public string $categoryName,public int $categoryId)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'A new category was created.',
            'category_id' => $this->categoryId,
            'category_name' => $this->categoryName,
        ];
    }
}
