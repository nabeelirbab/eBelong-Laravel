<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Helper;
use App\WorkDiary;
use App\SiteManagement;
use DB;
use App\Payout;
use Illuminate\Support\Facades\Schema;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\pymentStatusChange::class,
        Commands\SitemapCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
       $schedule->command('payment:statuschange')->hourly();
       $schedule->command('generate:sitemap')->dailyAt('21:45')->timezone('Asia/Karachi');
       $schedule->call( 
           function () {
                info("Updating Payouts");
                Helper::updatePayouts();
            }
            
           
       )->everyFiveMinutes();
       
       $schedule->call(  
            function () {
                \Log::info("WorkDiary Added on Monday 11:59");
                WorkDiary::submitFreelancerBill();
            })->weekly()->mondays()->at('11:59');
            
            /* function () {
                \Log::info("WorkDiary Added on Monday 11:59");
                WorkDiary::submitFreelancerBill();
                })->everyMinute();  */
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
