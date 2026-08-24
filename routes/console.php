<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

use Illuminate\Support\Facades\Schedule;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');



Schedule::command('app:check-expired-products')
          ->dailyAt('00:00')
          ->timezone('Asia/Amman');
        
//dailyAt('00:00')--->12 AM
//dailyAt('12:00')--->12 PM          