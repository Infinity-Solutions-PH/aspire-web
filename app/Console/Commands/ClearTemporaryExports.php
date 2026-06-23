<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearTemporaryExports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exports:clear-tmp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Safely clear out old and orphaned student export files from the system /tmp directory';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Scanning /tmp directory for stale student export files...');

        // Gather both the main tracking placeholders and the zip archives
        $patterns = [
            sys_get_temp_dir() . '/student_export_*',
            sys_get_temp_dir() . '/csv_export_*',
            sys_get_temp_dir() . '/export_*'
        ];

        $files = [];
        foreach ($patterns as $pattern) {
            $files = array_merge($files, glob($pattern) ?: []);
        }

        if (empty($files)) {
            $this->info('Nothing to clean! The /tmp directory is already pristine.');
            return Command::SUCCESS;
        }

        $count = 0;
        $freedBytes = 0;

        foreach ($files as $file) {
            if (is_file($file)) {
                $freedBytes += filesize($file);
                if (@unlink($file)) {
                    $count++;
                } else {
                    $this->error("Failed to delete: " . basename($file) . " (Check permissions)");
                }
            }
        }

        // Convert freed bytes to a human-readable MB format
        $freedMb = round($freedBytes / 1024 / 1024, 2);

        $this->info("Success! Cleared {$count} files and reclaimed {$freedMb} MB of disk space.");

        return Command::SUCCESS;
    }
}
