<?php

namespace App\Jobs;

use App\Models\Categorios;
use App\Models\User;
use App\Mail\CategoryCreatedMail;
use App\Notifications\CategoryCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class processcategorios implements ShouldQueue
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
        $category = Categorios::findOrFail($this->id);

        User::admins()->each(function (User $user) use ($category) {
            $user->notify(
                new CategoryCreatedNotification(
                    $category->name,
                    (int) $category->id
                )
            );
            Mail::to($user->email)->send(
                new CategoryCreatedMail(
                    $category->name,
                    (int) $category->id
                )
            );
        });
    }
}
