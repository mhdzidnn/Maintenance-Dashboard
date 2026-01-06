<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProxmoxController extends Controller
{
    public function index() { return view('proxmox.index'); }
    public function nodes($location = 'ags') 
    { 
        $nodeName = 'pve-' . $location;
        $allVms = [];

        // Define base VMs and modify stats based on location to create distinct visualizations
        switch($location) {
            case 'pusat': // High Load Scenario
                $title = 'Proxmox Kantor Pusat';
                $allVms = [
                    (object)[
                        'id' => 1, 'name' => 'win10-multifunction', 'is_running' => true, 'vm_id' => '101', 
                        'node' => (object)['name' => $nodeName], 'os_type' => 'windows', 
                        'formatted_uptime' => '10d 2h 30m', 'cpu_usage_percent' => 85, 'cpu_cores' => 4,
                        'memory_usage_percent' => 90, 'formatted_memory' => '8.00 GB', 'usage_gb' => 120,
                        'last_synced_at' => now()->subMinutes(1)
                    ],
                    (object)[
                        'id' => 2, 'name' => 'win10-backup', 'is_running' => true, 'vm_id' => '102', 
                        'node' => (object)['name' => $nodeName], 'os_type' => 'windows', 
                        'formatted_uptime' => '15d 5h 10m', 'cpu_usage_percent' => 60, 'cpu_cores' => 2,
                        'memory_usage_percent' => 75, 'formatted_memory' => '4.00 GB', 'usage_gb' => 450,
                        'last_synced_at' => now()->subMinutes(2)
                    ],
                    (object)[
                        'id' => 3, 'name' => 'win10-development', 'is_running' => true, 'vm_id' => '103', 
                        'node' => (object)['name' => $nodeName], 'os_type' => 'windows', 
                        'formatted_uptime' => '2d 1h 0m', 'cpu_usage_percent' => 45, 'cpu_cores' => 4,
                        'memory_usage_percent' => 50, 'formatted_memory' => '8.00 GB', 'usage_gb' => 100,
                        'last_synced_at' => now()->subMinutes(5)
                    ],
                    (object)[
                        'id' => 4, 'name' => 'win10-production', 'is_running' => true, 'vm_id' => '104', 
                        'node' => (object)['name' => $nodeName], 'os_type' => 'windows', 
                        'formatted_uptime' => '30d 12h 0m', 'cpu_usage_percent' => 95, 'cpu_cores' => 8,
                        'memory_usage_percent' => 92, 'formatted_memory' => '16.00 GB', 'usage_gb' => 500,
                        'last_synced_at' => now()->subMinutes(1)
                    ],
                ];
                break;

            case 'punggur': // Storage Heavy / Idle Scenario
                $title = 'Proxmox Punggur';
                $allVms = [
                    (object)[ // Multifunction stopped
                        'id' => 1, 'name' => 'win10-multifunction', 'is_running' => false, 'vm_id' => '201', 
                        'node' => (object)['name' => $nodeName], 'os_type' => 'windows', 
                        'formatted_uptime' => null, 'cpu_usage_percent' => 0, 'cpu_cores' => 4,
                        'memory_usage_percent' => 0, 'formatted_memory' => '8.00 GB', 'usage_gb' => 120,
                        'last_synced_at' => now()->subHours(2)
                    ],
                    (object)[ // Backup running hard
                        'id' => 2, 'name' => 'win10-backup', 'is_running' => true, 'vm_id' => '202', 
                        'node' => (object)['name' => $nodeName], 'os_type' => 'windows', 
                        'formatted_uptime' => '5d 2h 10m', 'cpu_usage_percent' => 15, 'cpu_cores' => 2,
                        'memory_usage_percent' => 30, 'formatted_memory' => '4.00 GB', 'usage_gb' => 480, // High storage usage
                        'last_synced_at' => now()->subMinutes(10)
                    ],
                    (object)[ // Development idle
                        'id' => 3, 'name' => 'win10-development', 'is_running' => true, 'vm_id' => '203', 
                        'node' => (object)['name' => $nodeName], 'os_type' => 'windows', 
                        'formatted_uptime' => '1h 30m', 'cpu_usage_percent' => 2, 'cpu_cores' => 4,
                        'memory_usage_percent' => 15, 'formatted_memory' => '8.00 GB', 'usage_gb' => 100,
                        'last_synced_at' => now()->subMinutes(5)
                    ],
                    (object)[
                        'id' => 4, 'name' => 'win10-production', 'is_running' => false, 'vm_id' => '204', 
                        'node' => (object)['name' => $nodeName], 'os_type' => 'windows', 
                        'formatted_uptime' => null, 'cpu_usage_percent' => 0, 'cpu_cores' => 8,
                        'memory_usage_percent' => 0, 'formatted_memory' => '16.00 GB', 'usage_gb' => 500,
                        'last_synced_at' => now()->subHours(12)
                    ],
                ];
                break;

            case 'sekupang': // Balanced / Mixed Scenario
                $title = 'Proxmox Sekupang';
                $allVms = [
                    (object)[
                        'id' => 1, 'name' => 'win10-multifunction', 'is_running' => true, 'vm_id' => '301', 
                        'node' => (object)['name' => $nodeName], 'os_type' => 'windows', 
                        'formatted_uptime' => '3d 12h 0m', 'cpu_usage_percent' => 35, 'cpu_cores' => 4,
                        'memory_usage_percent' => 45, 'formatted_memory' => '8.00 GB', 'usage_gb' => 120,
                        'last_synced_at' => now()->subMinutes(5)
                    ],
                    (object)[
                        'id' => 2, 'name' => 'win10-backup', 'is_running' => true, 'vm_id' => '302', 
                        'node' => (object)['name' => $nodeName], 'os_type' => 'windows', 
                        'formatted_uptime' => '3d 12h 0m', 'cpu_usage_percent' => 10, 'cpu_cores' => 2,
                        'memory_usage_percent' => 25, 'formatted_memory' => '4.00 GB', 'usage_gb' => 200,
                        'last_synced_at' => now()->subMinutes(5)
                    ],
                    (object)[
                        'id' => 3, 'name' => 'win10-development', 'is_running' => false, 'vm_id' => '303', 
                        'node' => (object)['name' => $nodeName], 'os_type' => 'windows', 
                        'formatted_uptime' => null, 'cpu_usage_percent' => 0, 'cpu_cores' => 4,
                        'memory_usage_percent' => 0, 'formatted_memory' => '8.00 GB', 'usage_gb' => 100,
                        'last_synced_at' => now()->subDays(1)
                    ],
                    (object)[
                        'id' => 4, 'name' => 'win10-production', 'is_running' => true, 'vm_id' => '304', 
                        'node' => (object)['name' => $nodeName], 'os_type' => 'windows', 
                        'formatted_uptime' => '20d 5h 0m', 'cpu_usage_percent' => 65, 'cpu_cores' => 8,
                        'memory_usage_percent' => 70, 'formatted_memory' => '16.00 GB', 'usage_gb' => 500,
                        'last_synced_at' => now()->subMinutes(1)
                    ],
                ];
                break;

            case 'ags':
            default: // Default Scenario (Low Load)
                $title = 'Proxmox AGS';
                $allVms = [
                    (object)[
                        'id' => 1, 'name' => 'win10-multifunction', 'is_running' => true, 'vm_id' => '101', 
                        'node' => (object)['name' => $nodeName], 'os_type' => 'windows', 
                        'formatted_uptime' => '5d 1h 30m', 'cpu_usage_percent' => 15, 'cpu_cores' => 4,
                        'memory_usage_percent' => 30, 'formatted_memory' => '8.00 GB', 'usage_gb' => 80,
                        'last_synced_at' => now()->subMinutes(5)
                    ],
                    (object)[
                        'id' => 2, 'name' => 'win10-backup', 'is_running' => true, 'vm_id' => '102', 
                        'node' => (object)['name' => $nodeName], 'os_type' => 'windows', 
                        'formatted_uptime' => '12d 2h 10m', 'cpu_usage_percent' => 5, 'cpu_cores' => 2,
                        'memory_usage_percent' => 20, 'formatted_memory' => '4.00 GB', 'usage_gb' => 50,
                        'last_synced_at' => now()->subMinutes(2)
                    ],
                    (object)[
                        'id' => 3, 'name' => 'win10-development', 'is_running' => false, 'vm_id' => '103', 
                        'node' => (object)['name' => $nodeName], 'os_type' => 'windows', 
                        'formatted_uptime' => null, 'cpu_usage_percent' => 0, 'cpu_cores' => 4,
                        'memory_usage_percent' => 0, 'formatted_memory' => '8.00 GB', 'usage_gb' => 100,
                        'last_synced_at' => now()->subHours(1)
                    ],
                    (object)[
                        'id' => 4, 'name' => 'win10-production', 'is_running' => true, 'vm_id' => '104', 
                        'node' => (object)['name' => $nodeName], 'os_type' => 'windows', 
                        'formatted_uptime' => '1d 1h 0m', 'cpu_usage_percent' => 25, 'cpu_cores' => 8,
                        'memory_usage_percent' => 35, 'formatted_memory' => '16.00 GB', 'usage_gb' => 200,
                        'last_synced_at' => now()->subMinutes(1)
                    ],
                ];
                break;
        }

        $vms = collect($allVms); // Convert array to Collection for view compatibility (count(), where(), sum())

        return view('proxmox.nodes', compact('vms', 'title', 'location')); 
    }
    public function storage() { return view('proxmox.storage'); }
    public function vms() { return view('proxmox.vms'); }
    public function memory() { return view('proxmox.memory'); }
}
