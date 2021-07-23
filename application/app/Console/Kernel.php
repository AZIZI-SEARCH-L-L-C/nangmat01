<?php

namespace AziziSearchEngineStarter\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use AziziSearchEngineStarter\AdsCompain;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
		// $schedule->call(function () {
			// $compain = new AdsCompain;
			// $compain->name = str_random(5);
			// $compain->user_id = 1;
			// $compain->save();
            // DB::table('ads_compains')->insert(['name' => 'gfg', 'user_id' => 1]);
        // })->everyMinute();
		
		$schedule->call(function () {
			$compain = new AdsCompain;
			$compain->name = str_random(5);
			$compain->user_id = 2;
			$compain->save();
            // DB::table('ads_compains')->insert(['name' => 'gfg', 'user_id' => 1]);
        })->everyTenMinutes();
        // $schedule->command('inspire')
        //          ->hourly();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
