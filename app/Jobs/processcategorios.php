<?php

namespace App\Jobs;

use App\Models\Categorios;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class processcategorios implements ShouldQueue
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
        $category=Categorios::findOrFile($this->id);
        logger()->info('Categorios process successfully',[
            'category_id'=>$category_id
        ]);

    }
}
