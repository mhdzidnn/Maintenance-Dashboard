<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NextcloudStat;
use App\Models\NextcloudUser;

class NextcloudSeeder extends Seeder
{
    public function run(): void
    {
        NextcloudStat::create([
            'status' => 'online',
            'total_users' => 81,
            'storage_used_tb' => 2.3,
            'storage_total_tb' => 5.0,
        ]);

        NextcloudUser::create([
            'username' => 'joko',
            'quota_used_gb' => 2.5,
            'quota_total_gb' => 5.0,
            'last_login' => now()->subMinutes(5),
        ]);

        NextcloudUser::create([
            'username' => 'ana',
            'quota_used_gb' => 3.2,
            'quota_total_gb' => 5.0,
            'last_login' => now()->subHours(1),
        ]);
        
        NextcloudUser::create([
            'username' => 'susi',
            'quota_used_gb' => 1.8,
            'quota_total_gb' => 5.0,
            'last_login' => now()->subDays(2),
        ]);

        NextcloudUser::create([
            'username' => 'andi',
            'quota_used_gb' => 4.7,
            'quota_total_gb' => 5.0,
            'last_login' => now()->subDays(1),
        ]);
    }
}
