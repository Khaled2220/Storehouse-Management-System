<?php

namespace App\Listeners;

use App\Events\StockMovementCreated;
use App\Jobs\ProcessStockMovementCreated as ProcessStockMovementCreatedJob;

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
