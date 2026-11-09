<?php

namespace App\Listeners;

use App\Events\ProductCreated;
use App\Jobs\ProcessProductCreated as ProcessProductCreatedJob;

class ProcessProductCreated
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ProductCreated $event): void
    {
        ProcessProductCreatedJob::dispatch($event->product->id);
    }
}
