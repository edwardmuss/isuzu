<?php

namespace App\Console\Commands;

use App\Models\UssdSession;
use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;

//* * * * * php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1

class ScheduleCleanUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Schedule cleanup of old USSD sessions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Perform the cleanup logic for sessions older than 5 minutes
        $deletedCount = UssdSession::where('updated_at', '<', now()->subMinutes(5))->delete();

        // Provide feedback to the user
        $this->info("Manual cleanup executed. Deleted {$deletedCount} session(s) older than 5 minutes.");
    }
}
