<?php

namespace Database\Seeders;

use App\Models\Node;
use App\Models\VirtualMachine;
use Illuminate\Database\Seeder;

class ProxmoxVMSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default node
        $node = Node::firstOrCreate(
            ['name' => 'pve'],
            [
                'name' => 'pve',
                'status' => 'healthy',
                'uptime_days' => 41,
                'uptime_percentage' => 99.95
            ]
        );

        // Create sample Windows 10 VMs with realistic data
        $vms = [
            [
                'name' => 'win10-multifunction',
                'vm_id' => '100',
                'usage_gb' => 100,
                'cpu_cores' => 2,
                'cpu_usage_percent' => 5.34,
                'memory_total_mb' => 4096,
                'memory_used_mb' => 3213,
                'memory_usage_percent' => 78.36,
                'uptime_seconds' => 3616507, // 41 days 18:55:07
                'is_running' => true,
                'status' => 'running',
                'os_type' => 'Windows 10',
            ],
            [
                'name' => 'win10-backup',
                'vm_id' => '101',
                'usage_gb' => 120,
                'cpu_cores' => 4,
                'cpu_usage_percent' => 12.5,
                'memory_total_mb' => 8192,
                'memory_used_mb' => 4096,
                'memory_usage_percent' => 50.0,
                'uptime_seconds' => 2592000, // 30 days
                'is_running' => true,
                'status' => 'running',
                'os_type' => 'Windows 10',
            ],
            [
                'name' => 'win10-development',
                'vm_id' => '102',
                'usage_gb' => 150,
                'cpu_cores' => 4,
                'cpu_usage_percent' => 25.8,
                'memory_total_mb' => 16384,
                'memory_used_mb' => 12288,
                'memory_usage_percent' => 75.0,
                'uptime_seconds' => 1296000, // 15 days
                'is_running' => true,
                'status' => 'running',
                'os_type' => 'Windows 10',
            ],
        ];

        foreach ($vms as $vmData) {
            VirtualMachine::updateOrCreate(
                [
                    'vm_id' => $vmData['vm_id'],
                    'node_id' => $node->id
                ],
                array_merge($vmData, [
                    'node_id' => $node->id,
                    'last_synced_at' => now()
                ])
            );
        }

        $this->command->info('✓ Created ' . count($vms) . ' sample VMs');
    }
}
