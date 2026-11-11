<?php

namespace App\Listeners;

use App\Jobs\ProcessCategoryCreated as ProcessCategoryCreatedJob;
use App\Events\CategoryCreated;

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
    public function handle(CategoryCreated $event): void
    {
        ProcessCategoryCreatedJob::dispatch($event->category->id);
    }
}
