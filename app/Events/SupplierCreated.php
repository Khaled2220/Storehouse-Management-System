<?php

namespace App\Events;

use App\Models\Supplier;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SupplierCreated
{
    use Dispatchable, SerializesModels;

    public function __construct(public Supplier $supplier)
    {
        //
    }
}