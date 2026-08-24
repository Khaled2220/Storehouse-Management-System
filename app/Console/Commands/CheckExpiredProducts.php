<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

use App\Models\Products; 
use Carbon\Carbon;  


#[Signature('app:check-expired-products')]
#[Description('Command description')]
class CheckExpiredProducts extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
       $updatedCount = Products::where('expiry_date', '<=', Carbon::today('Asia/Amman')->toDateString())
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




