<?php

namespace App\Events;

use App\Models\Categorios;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class category
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public Categorios $category)
    {
        //
    }
}
