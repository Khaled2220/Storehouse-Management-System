<?php

namespace App\Listeners;

//use App\Models\product;
use App\Events\product;
use App\Job\processproducts;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProcessProductCreated
{
    /**
     * Create the event listener.
     */
    public function __construct(public Products $product)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(product $event): void
    {
        ProcessProducts::dispath($event->product->id);
    }
}
