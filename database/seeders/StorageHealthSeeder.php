<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StorageHealth;
use App\Models\Node;

class StorageHealthSeeder extends Seeder
{
    public function run(): void
    {
        $prox01 = Node::where('name', 'prox01')->first();
        $prox02 = Node::where('name', 'prox02')->first();

        StorageHealth::create([
            'node_id' => $prox01->id,
            'name' => 'LOCAL-LVM',
            'usage_percentage' => 85.0,
            'local_percentage' => 33.0,
            'raid_status' => 'HEALTHY',
            'trend' => '+4% / week',
            'alert_level' => 'warning',
        ]);

        StorageHealth::create([
            'node_id' => $prox02->id,
            'name' => 'LOCAL-LVM',
            'usage_percentage' => 92.0,
            'local_percentage' => 85.0,
            'raid_status' => 'RAID1-Degraded',
            'trend' => '+5% / week',
            'alert_level' => 'warning',
        ]);
    }
}
