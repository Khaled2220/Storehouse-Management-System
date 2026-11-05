<?php

namespace App\Listeners;

use App\Events\product;
use App\Jobs\processproducts;

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
    public function handle(product $event): void
    {
        processproducts::dispatch($event->product->id);
    }
}
