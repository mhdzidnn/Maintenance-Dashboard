<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use App\Models\ProxmoxNode;
use App\Models\ProxmoxVm;


class ProxmoxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        // 1. AGS Node (pve-ags)
        $agsNode = ProxmoxNode::create([
            'name' => 'pve-ags',
            'location' => 'ags',
            'ip_address' => '10.10.10.1', 
            'status' => 'online',
            'cpu_usage' => 0.15,
            'memory_usage' => 10.5,
            'disk_usage' => 45.2,
            'uptime' => '120d 2h',
        ]);
        
        $agsNode->vms()->createMany([
            [
                'vm_id' => 100, 'name' => 'win10-multifunction', 'status' => 'running', 'os_type' => 'windows',
                'cpu_cores' => 4, 'memory_total_gb' => 8, 'disk_total_gb' => 120,
                'cpu_usage_percent' => 15, 'memory_usage_percent' => 30, 'disk_usage_gb' => 80, 'formatted_uptime' => '5d 1h 30m'
            ],
            [
                'vm_id' => 101, 'name' => 'win10in02', 'status' => 'running', 'os_type' => 'windows',
                'cpu_cores' => 2, 'memory_total_gb' => 4, 'disk_total_gb' => 60,
                'cpu_usage_percent' => 5, 'memory_usage_percent' => 20, 'disk_usage_gb' => 50, 'formatted_uptime' => '12d 2h 10m'
            ],
            [
                'vm_id' => 102, 'name' => 'win10in01', 'status' => 'stopped', 'os_type' => 'windows',
                'cpu_cores' => 4, 'memory_total_gb' => 8, 'disk_total_gb' => 100,
                'cpu_usage_percent' => 0, 'memory_usage_percent' => 0, 'disk_usage_gb' => 100, 'formatted_uptime' => null
            ],
            [
                'vm_id' => 103, 'name' => 'ubuntu-24', 'status' => 'running', 'os_type' => 'linux',
                'cpu_cores' => 8, 'memory_total_gb' => 16, 'disk_total_gb' => 500,
                'cpu_usage_percent' => 25, 'memory_usage_percent' => 35, 'disk_usage_gb' => 200, 'formatted_uptime' => '1d 1h 0m'
            ],
            [
                'vm_id' => 6690, 'name' => 'vpn-site-to-site', 'status' => 'running', 'type' => 'lxc', 'os_type' => 'linux',
                'cpu_cores' => 1, 'memory_total_gb' => 1, 'disk_total_gb' => 20,
                'cpu_usage_percent' => 2, 'memory_usage_percent' => 50, 'disk_usage_gb' => 200, 'formatted_uptime' => '45d 12h'
            ]
        ]);

        // 2. Pusat Node (pve-pusat)
        $pusatNode = ProxmoxNode::create([
            'name' => 'pve-pusat',
            'location' => 'pusat',
            'ip_address' => '10.10.20.1',
            'status' => 'online',
            'cpu_usage' => 0.45,
            'memory_usage' => 32.0,
            'disk_usage' => 120.5,
            'uptime' => '15d 5h',
        ]);

        $pusatNode->vms()->createMany([
             [
                'vm_id' => 100, 'name' => 'win10-multifunction', 'status' => 'running', 'os_type' => 'windows',
                'cpu_cores' => 4, 'memory_total_gb' => 8, 'disk_total_gb' => 120,
                'cpu_usage_percent' => 85, 'memory_usage_percent' => 90, 'disk_usage_gb' => 120, 'formatted_uptime' => '10d 2h 30m'
            ],
            [
                'vm_id' => 101, 'name' => 'win10in02', 'status' => 'running', 'os_type' => 'windows',
                'cpu_cores' => 2, 'memory_total_gb' => 4, 'disk_total_gb' => 500, 
                'cpu_usage_percent' => 60, 'memory_usage_percent' => 75, 'disk_usage_gb' => 450, 'formatted_uptime' => '15d 5h 10m'
            ],
            [
                'vm_id' => 102, 'name' => 'win10in01', 'status' => 'running', 'os_type' => 'windows',
                'cpu_cores' => 4, 'memory_total_gb' => 8, 'disk_total_gb' => 100,
                'cpu_usage_percent' => 45, 'memory_usage_percent' => 50, 'disk_usage_gb' => 100, 'formatted_uptime' => '2d 1h 0m'
            ],
            [
                'vm_id' => 103, 'name' => 'ubuntu-24', 'status' => 'running', 'os_type' => 'linux',
                'cpu_cores' => 8, 'memory_total_gb' => 16, 'disk_total_gb' => 500,
                'cpu_usage_percent' => 95, 'memory_usage_percent' => 92, 'disk_usage_gb' => 500, 'formatted_uptime' => '30d 12h 0m'
            ],
        ]);
        
        // 3. Punggur Node
        $punggurNode = ProxmoxNode::create([
            'name' => 'pve-punggur', 'location' => 'punggur', 'status' => 'online',
        ]);
        $punggurNode->vms()->createMany([
             ['vm_id' => 100, 'name' => 'win10-multifunction', 'status' => 'stopped', 'os_type' => 'windows'],
             ['vm_id' => 101, 'name' => 'win10in02', 'status' => 'running', 'os_type' => 'windows', 'cpu_usage_percent' => 15, 'memory_usage_percent' => 30],
        ]);

        // 4. Sekupang Node
        $sekupangNode = ProxmoxNode::create([
            'name' => 'pve-sekupang', 'location' => 'sekupang', 'status' => 'online',
        ]);
        $sekupangNode->vms()->createMany([
             ['vm_id' => 100, 'name' => 'win10-multifunction', 'status' => 'running', 'os_type' => 'windows', 'cpu_usage_percent' => 35],
             ['vm_id' => 103, 'name' => 'ubuntu-24', 'status' => 'running', 'os_type' => 'linux', 'cpu_usage_percent' => 65],
        ]);
    }

}
