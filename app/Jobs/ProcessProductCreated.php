<?php

namespace App\Jobs;

use App\Mail\ProductCreatedMail;
use App\Models\Product;
use App\Models\User;
use App\Notifications\ProductCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class ProcessProductCreated implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public int $id)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $product = Product::findOrFail($this->id);

        User::admins()->each(function (User $user) use ($product) {
            $user->notify(
                new ProductCreatedNotification(
                    $product->name,
                    (int) $product->id
                )
            );
            Mail::to($user->email)->send(
                new ProductCreatedMail(
                    $product->name,
                    (int) $product->id
                )
            );
        });
    }
}
