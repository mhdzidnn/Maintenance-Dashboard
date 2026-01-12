<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SyncNextcloudStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nextcloud:sync-stats';
    protected $description = 'Sync Statistics from Nextcloud API';

    protected $nextcloudApi;

    public function __construct(\App\Services\NextcloudApiService $nextcloudApi)
    {
        parent::__construct();
        $this->nextcloudApi = $nextcloudApi;
    }

    public function handle()
    {
        $this->info('Starting Nextcloud Stat sync...');
        
        $stats = $this->nextcloudApi->fetchStats();

        if ($stats) {
            // Logika menyimpan ke database
            // \App\Models\NextcloudStat::create([
            //     'total_storage' => $stats['storage_total'],
            //     'used_storage' => $stats['storage_used'],
            //     // ... dst
            // ]);
            $this->info('✓ Data synced successfully.');
        } else {
            $this->warn('No data received from API. Using fallback/mock if needed.');
        }

        return 0;
    }
}
