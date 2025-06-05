<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    
    protected $commands = [
        \App\Console\Commands\SendEvaluationEmails::class,
        \App\Console\Commands\RunScheduler::class,
    ];


    protected function schedule(Schedule $schedule)
    {
        $schedule->command('send:evaluation-emails')->everyMinute();
    }
    

//     protected function schedule(Schedule $schedule)
// {
//     $schedule->command('send:evaluation-emails')->everyMinute();
// }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
