<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Supplier;
use Illuminate\Support\Facades\Mail;
use App\Mail\SupplierCreatedMail;
use App\Notifications\SupplierCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessSupplierCreated implements ShouldQueue
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
        $supplier = Supplier::findOrFail($this->id);

        User::admins()->each(function (User $user) use ($supplier) {

            $user->notify(
                new SupplierCreatedNotification(
                    $supplier->name,
                    (int) $supplier->id
                )
            );
            Mail::to($user->email)->send(
                new SupplierCreatedMail(
                    $supplier->name,
                    (int) $supplier->id
                )
            );

        });
    }
}
