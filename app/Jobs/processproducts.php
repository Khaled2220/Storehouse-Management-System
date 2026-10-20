<?php

namespace App\Jobs;

use App\Models\Products;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class processproducts implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public int $id)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $product=Products::findOrFail($this->id);
        
        logger()->info('Product processed successfully', [
            'product_id' => $product->id,
        ]);
    }
}
