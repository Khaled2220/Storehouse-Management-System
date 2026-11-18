<?php

namespace App\Jobs;

use App\Mail\SupplierCreatedMail;
use App\Models\Supplier;
use App\Models\User;
use App\Notifications\SupplierCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

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
            try {
                Mail::to($user->email)->send(
                    new SupplierCreatedMail(
                        $supplier->name,
                        (int) $supplier->id
                    )
                );
            } catch (Throwable $exception) {
                Log::error('Supplier Create Email could not be send.', [
                    'user_id' => $user->id,
                    'suppler_id' => $supplier->id,
                    'error' => $exception->getMessage(),
                ]);
            }
        });
    }
}
