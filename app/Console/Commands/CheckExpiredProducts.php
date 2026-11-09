<?php

namespace App\Console\Commands;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:check-expired-products')]
#[Description('Mark active products as expired when their expiry date is today or earlier.')]

class CheckExpiredProducts extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $updatedCount = Product::where(
            'expiry_date',
            '<=',
            Carbon::today(config('app.timezone'))->toDateString()
        )
            ->where('status', 'active')
            ->update(['status' => 'expired']);

        if ($updatedCount === 0) {
            $this->info('There are no expired products today.');
        } else {
            $this->info("Successfully updated {$updatedCount} expired products.");
        }

        return Command::SUCCESS;
    }
}
