<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProductCreatedMail;
use App\Notifications\ProductCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

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
