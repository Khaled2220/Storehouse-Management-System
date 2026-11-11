<?php

namespace App\Listeners;

use App\Jobs\ProcessStockMovementCreated as ProcessStockMovementCreatedJob;
use App\Events\StockMovementCreated;

class ProcessStockMovementCreated
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
    public function handle(StockMovementCreated $event): void
    {
            ProcessStockMovementCreatedJob::dispatch($event->stockMovement->id);
    }
}
