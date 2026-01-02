<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SystemAlert;

class SystemAlertSeeder extends Seeder
{
    public function run(): void
    {
        SystemAlert::create([
            'type' => 'warning',
            'title' => 'LOCAL-LVM Usage High!',
            'message' => '85% (1.5 TB / 1.7 TB)',
            'details' => null,
            'is_resolved' => false,
        ]);

        SystemAlert::create([
            'type' => 'critical',
            'title' => 'Nextcloud: User Quota Exceeded',
            'message' => 'User andi has exceeded quota (94%)',
            'details' => '4.7 GB / 5.0 GB used',
            'is_resolved' => false,
        ]);
    }
}
