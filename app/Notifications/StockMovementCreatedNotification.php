<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class StockMovementCreatedNotification extends Notification
{
    /**
     * Create a new notification instance.
     */
    public function __construct(public int $stockMovementId, public string $productName, public string $type, public int $quantity)
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
            'message' => 'A new stock movement was recorded.',
            'stock_movement_id' => $this->stockMovementId,
            'product_name' => $this->productName,
            'type' => $this->type,
            'quantity' => $this->quantity,
        ];
    }
}
