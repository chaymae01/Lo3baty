<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RunScheduler extends Command
{
    protected $signature = 'run:scheduler';
    protected $description = 'Run the scheduler continuously';

    public function handle()
    {
        $this->info('Scheduler started. Press Ctrl+C to stop.');

        while (true) {
            $this->call('schedule:run');
            sleep(60); // Checks every minute
        }
    }
}