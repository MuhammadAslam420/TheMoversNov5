<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ClearWorkerLogs extends Command
{
    protected $signature = 'logs:clear';

    protected $description = 'Clear Laravel worker logs';

    public function handle()
    {
        $logPath = storage_path('logs');

        // Ensure the logs directory exists
        if (File::exists($logPath)) {
            // Get all log files in the directory
            $logFiles = File::glob("$logPath/*.log");

            // Loop through the log files and delete them
            foreach ($logFiles as $logFile) {
                File::delete($logFile);
            }

            $this->info('Worker logs have been cleared.');
        } else {
            $this->info('Logs directory not found.');
        }
    }
}
