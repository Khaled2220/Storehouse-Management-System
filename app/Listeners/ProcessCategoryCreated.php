<?php

namespace App\Listeners;

use App\Events\category;
use App\Jobs\processcategorios;

class ProcessCategoryCreated
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
    public function handle(category $event): void
    {
        processcategorios::dispatch($event->category->id);
    }
}
