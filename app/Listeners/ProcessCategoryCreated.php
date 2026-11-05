<?php

namespace App\Listeners;

use App\Events\CategoryCreated;
use App\Jobs\ProcessCategoryCreated as ProcessCategoryCreatedJob;

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
