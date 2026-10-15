<?php

namespace App\Listeners;

//use App\Models\product;
use App\Events\product;
use App\Jobs\processproducts;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
