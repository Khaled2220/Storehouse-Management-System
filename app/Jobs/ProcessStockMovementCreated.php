<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\StockMovement;
use Illuminate\Support\Facades\Mail;
use App\Mail\StockMovementCreatedMail;
use App\Notifications\StockMovementCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessStockMovementCreated implements ShouldQueue
{
    use Queueable;

    public function __construct(public int $id)
    {
        //
    }

    public function handle(): void
    {
        $stockMovement = StockMovement::with('product')
            ->findOrFail($this->id);

        User::admins()->each(function (User $user) use ($stockMovement) {
            $user->notify(
                new StockMovementCreatedNotification(
                    (int) $stockMovement->id,
                    $stockMovement->product->name,
                    $stockMovement->type,
                    (int) $stockMovement->quantity
                )
            );
            Mail::to($user->email)->send(
                new StockMovementCreatedMail(
                    (int) $stockMovement->id,
                    $stockMovement->product->name,
                    $stockMovement->type,
                    (int) $stockMovement->quantity,
                    $stockMovement->movement_date->format('Y-m-d')
                )
            );

        });
    }
}