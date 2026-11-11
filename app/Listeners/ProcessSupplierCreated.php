<?php

namespace App\Listeners;

use App\Jobs\ProcessSupplierCreated as ProcessSupplierCreatedJob;
use App\Events\SupplierCreated;

class ProcessSupplierCreated
{
    public function handle(SupplierCreated $event): void
    {
        ProcessSupplierCreatedJob::dispatch($event->supplier->id);
    }
}