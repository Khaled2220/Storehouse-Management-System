<?php

namespace App\Listeners;

//use App\Models\Category;
use App\Events\category;
use App\Job\processcategorios;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProcessCategoryCreated
{
    /**
     * Create the event listener.
     */
    public function __construct(public Categorios $category)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(category $event): void
    {
        ProcessCategories::dispath($event->category->id);
    }
}
