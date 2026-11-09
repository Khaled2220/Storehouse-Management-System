<?php

namespace App\Listeners;

use App\Events\SupplierCreated;
use App\Jobs\ProcessSupplierCreated as ProcessSupplierCreatedJob;

class ProcessSupplierCreated
{
    public function handle(SupplierCreated $event): void
    {
        ProcessSupplierCreatedJob::dispatch($event->supplier->id);
    }
}