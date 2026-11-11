<?php

namespace App\Listeners;

use App\Jobs\ProcessProductCreated as ProcessProductCreatedJob;
use App\Events\ProductCreated;

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
