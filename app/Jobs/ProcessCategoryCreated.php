<?php

namespace App\Jobs;

use App\Mail\CategoryCreatedMail;
use App\Models\Category;
use App\Models\User;
use App\Notifications\CategoryCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class ProcessCategoryCreated implements ShouldQueue
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
        $category = Category::findOrFail($this->id);

        User::admins()->each(function (User $user) use ($category) {
            $user->notify(
                new CategoryCreatedNotification(
                    $category->name,
                    (int) $category->id
                )
            );

            try {
                Mail::to($user->email)->send(
                    new CategoryCreatedMail(
                        $category->name,
                        (int) $category->id
                    )
                );
            } catch (Throwable $exception) {
                Log::error('Category Create Email could not be send .', [
                    'user_id' => $user->id,
                    'category_id' => $category->id,
                    'error' => $exception->getMessage(),
                ]);
            }

        });
    }
}
