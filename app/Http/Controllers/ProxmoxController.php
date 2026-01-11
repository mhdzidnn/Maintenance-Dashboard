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
                        'id' => 100, 'name' => '100 (win10-multifunction)', 'is_running' => true, 'vm_id' => '100', 
                        'node' => (object)['name' => $nodeName], 'os_type' => 'windows', 
                        'formatted_uptime' => '10d 2h 30m', 'cpu_usage_percent' => 85, 'cpu_cores' => 4,
                        'memory_usage_percent' => 90, 'formatted_memory' => '8.00 GB', 'usage_gb' => 120,
                        'last_synced_at' => now()->subMinutes(1)
                    ],
                    (object)[
                        'id' => 101, 'name' => '101 (win10in02)', 'is_running' => true, 'vm_id' => '101', 
                        'node' => (object)['name' => $nodeName], 'os_type' => 'windows', 
                        'formatted_uptime' => '15d 5h 10m', 'cpu_usage_percent' => 60, 'cpu_cores' => 2,
                        'memory_usage_percent' => 75, 'formatted_memory' => '4.00 GB', 'usage_gb' => 450,
                        'last_synced_at' => now()->subMinutes(2)
                    ],
                    (object)[
                        'id' => 102, 'name' => '102 (win10in01)', 'is_running' => true, 'vm_id' => '102', 
                        'node' => (object)['name' => $nodeName], 'os_type' => 'windows', 
                        'formatted_uptime' => '2d 1h 0m', 'cpu_usage_percent' => 45, 'cpu_cores' => 4,
                        'memory_usage_percent' => 50, 'formatted_memory' => '8.00 GB', 'usage_gb' => 100,
                        'last_synced_at' => now()->subMinutes(5)
                    ],
                    (object)[
                        'id' => 103, 'name' => '103 (ubuntu-24)', 'is_running' => true, 'vm_id' => '103', 
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
                        'id' => 100, 'name' => '100 (win10-multifunction)', 'is_running' => false, 'vm_id' => '100', 
                        'node' => (object)['name' => $nodeName], 'os_type' => 'windows', 
                        'formatted_uptime' => null, 'cpu_usage_percent' => 0, 'cpu_cores' => 4,
                        'memory_usage_percent' => 0, 'formatted_memory' => '8.00 GB', 'usage_gb' => 120,
                        'last_synced_at' => now()->subHours(2)
                    ],
                    (object)[ // Backup running hard
                        'id' => 101, 'name' => '101 (win10in02)', 'is_running' => true, 'vm_id' => '101', 
                        'node' => (object)['name' => $nodeName], 'os_type' => 'windows', 
                        'formatted_uptime' => '5d 2h 10m', 'cpu_usage_percent' => 15, 'cpu_cores' => 2,
                        'memory_usage_percent' => 30, 'formatted_memory' => '4.00 GB', 'usage_gb' => 480, // High storage usage
                        'last_synced_at' => now()->subMinutes(10)
                    ],
                    (object)[ // Development idle
                        'id' => 102, 'name' => '102 (win10in01)', 'is_running' => true, 'vm_id' => '102', 
                        'node' => (object)['name' => $nodeName], 'os_type' => 'windows', 
                        'formatted_uptime' => '1h 30m', 'cpu_usage_percent' => 2, 'cpu_cores' => 4,
                        'memory_usage_percent' => 15, 'formatted_memory' => '8.00 GB', 'usage_gb' => 100,
                        'last_synced_at' => now()->subMinutes(5)
                    ],
                    (object)[
                        'id' => 103, 'name' => '103 (ubuntu-24)', 'is_running' => false, 'vm_id' => '103', 
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
                        'id' => 100, 'name' => '100 (win10-multifunction)', 'is_running' => true, 'vm_id' => '100', 
                        'node' => (object)['name' => $nodeName], 'os_type' => 'windows', 
                        'formatted_uptime' => '3d 12h 0m', 'cpu_usage_percent' => 35, 'cpu_cores' => 4,
                        'memory_usage_percent' => 45, 'formatted_memory' => '8.00 GB', 'usage_gb' => 120,
                        'last_synced_at' => now()->subMinutes(5)
                    ],
                    (object)[
                        'id' => 101, 'name' => '101 (win10in02)', 'is_running' => true, 'vm_id' => '101', 
                        'node' => (object)['name' => $nodeName], 'os_type' => 'windows', 
                        'formatted_uptime' => '3d 12h 0m', 'cpu_usage_percent' => 10, 'cpu_cores' => 2,
                        'memory_usage_percent' => 25, 'formatted_memory' => '4.00 GB', 'usage_gb' => 200,
                        'last_synced_at' => now()->subMinutes(5)
                    ],
                    (object)[
                        'id' => 102, 'name' => '102 (win10in01)', 'is_running' => false, 'vm_id' => '102', 
                        'node' => (object)['name' => $nodeName], 'os_type' => 'windows', 
                        'formatted_uptime' => null, 'cpu_usage_percent' => 0, 'cpu_cores' => 4,
                        'memory_usage_percent' => 0, 'formatted_memory' => '8.00 GB', 'usage_gb' => 100,
                        'last_synced_at' => now()->subDays(1)
                    ],
                    (object)[
                        'id' => 103, 'name' => '103 (ubuntu-24)', 'is_running' => true, 'vm_id' => '103', 
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
                        'id' => 100, 'name' => '100 (win10-multifunction)', 'is_running' => true, 'vm_id' => '100', 
                        'node' => (object)['name' => $nodeName], 'os_type' => 'windows', 
                        'formatted_uptime' => '5d 1h 30m', 'cpu_usage_percent' => 15, 'cpu_cores' => 4,
                        'memory_usage_percent' => 30, 'formatted_memory' => '8.00 GB', 'usage_gb' => 80,
                        'last_synced_at' => now()->subMinutes(5)
                    ],
                    (object)[
                        'id' => 101, 'name' => '101 (win10in02)', 'is_running' => true, 'vm_id' => '101', 
                        'node' => (object)['name' => $nodeName], 'os_type' => 'windows', 
                        'formatted_uptime' => '12d 2h 10m', 'cpu_usage_percent' => 5, 'cpu_cores' => 2,
                        'memory_usage_percent' => 20, 'formatted_memory' => '4.00 GB', 'usage_gb' => 50,
                        'last_synced_at' => now()->subMinutes(2)
                    ],
                    (object)[
                        'id' => 102, 'name' => '102 (win10in01)', 'is_running' => false, 'vm_id' => '102', 
                        'node' => (object)['name' => $nodeName], 'os_type' => 'windows', 
                        'formatted_uptime' => null, 'cpu_usage_percent' => 0, 'cpu_cores' => 4,
                        'memory_usage_percent' => 0, 'formatted_memory' => '8.00 GB', 'usage_gb' => 100,
                        'last_synced_at' => now()->subHours(1)
                    ],
                    (object)[
                        'id' => 103, 'name' => '103 (ubuntu-24)', 'is_running' => true, 'vm_id' => '103', 
                        'node' => (object)['name' => $nodeName], 'os_type' => 'windows', 
                        'formatted_uptime' => '1d 1h 0m', 'cpu_usage_percent' => 25, 'cpu_cores' => 8,
                        'memory_usage_percent' => 35, 'formatted_memory' => '16.00 GB', 'usage_gb' => 200,
                        'last_synced_at' => now()->subMinutes(1)
                    ],
                    (object)[
                        'id' => 6690, 'name' => '6690 (vpn-site-to-site)', 'is_running' => true, 'vm_id' => '6690', 
                        'node' => (object)['name' => $nodeName], 'os_type' => 'lxc', 
                        'formatted_uptime' => '45d 12h', 'cpu_usage_percent' => 2, 'cpu_cores' => 1,
                        'memory_usage_percent' => 50, 'formatted_memory' => '1.00 GB', 'usage_gb' => 20,
                        'last_synced_at' => now()->subMinutes(10)
                    ],
                ];
                break;
        }

        $vms = collect($allVms); // Convert array to Collection for view compatibility (count(), where(), sum())

        // Check for resource limits and generate notifications
        $notifications = [];
        foreach ($vms as $vm) {
            if (!$vm->is_running) continue;

            // CPU Usage (> 85%)
            if ($vm->cpu_usage_percent > 85) {
                $notifications[] = [
                    'id' => "alert_cpu_{$vm->id}_{$location}",
                    'type' => 'warning',
                    'title' => 'High CPU Usage',
                    'message' => "VM <strong>{$vm->name}</strong> is using <strong>{$vm->cpu_usage_percent}%</strong> CPU.",
                    'node' => $vm->node->name
                ];
            }

            // Memory Usage (> 85%)
            if ($vm->memory_usage_percent > 85) {
                $notifications[] = [
                    'id' => "alert_mem_{$vm->id}_{$location}",
                    'type' => 'warning',
                    'title' => 'High Memory Usage',
                    'message' => "VM <strong>{$vm->name}</strong> is using <strong>{$vm->memory_usage_percent}%</strong> Memory.",
                    'node' => $vm->node->name
                ];
            }

            // Disk Usage (> 450GB - assuming 500GB limit for now based on dummy data)
            if ($vm->usage_gb > 450) {
                 $notifications[] = [
                    'id' => "alert_disk_{$vm->id}_{$location}",
                    'type' => 'warning',
                    'title' => 'Low Disk Space',
                    'message' => "VM <strong>{$vm->name}</strong> has used <strong>{$vm->usage_gb}GB</strong> of storage (Limit: 500GB).",
                    'node' => $vm->node->name
                ];
            }
        }

        return view('proxmox.nodes', compact('vms', 'title', 'location', 'notifications')); 
    }

    public function datacenter($location = 'ags')
    {
        $nodeName = 'pve-' . $location;
        
        // Re-use logic to get VMs for the location (similar to nodes method)
        $allVms = [];
        switch($location) {
            case 'pusat':
                $allVms = [
                    (object)['id' => '100', 'name' => '100 (win10-multifunction)', 'status' => 'running', 'type' => 'qemu', 'cpu' => 0.15, 'mem' => 4.29, 'maxmem' => 8.58, 'maxdisk' => 107.37, 'uptime' => '10d 2h', 'host_cpu' => 5, 'host_mem' => 12],
                    (object)['id' => '101', 'name' => '101 (win10in02)', 'status' => 'running', 'type' => 'qemu', 'cpu' => 0.05, 'mem' => 2.15, 'maxmem' => 4.29, 'maxdisk' => 536.87, 'uptime' => '15d 5h', 'host_cpu' => 2, 'host_mem' => 8],
                    (object)['id' => '102', 'name' => '102 (win10in01)', 'status' => 'running', 'type' => 'qemu', 'cpu' => 0.10, 'mem' => 4.5, 'maxmem' => 8.58, 'maxdisk' => 107.37, 'uptime' => '2d 1h', 'host_cpu' => 4, 'host_mem' => 10],
                    (object)['id' => '103', 'name' => '103 (ubuntu-24)', 'status' => 'running', 'type' => 'qemu', 'cpu' => 0.45, 'mem' => 12.5, 'maxmem' => 17.17, 'maxdisk' => 536.87, 'uptime' => '30d 12h', 'host_cpu' => 15, 'host_mem' => 24],
                ];
                break;
            case 'punggur':
                $allVms = [
                    (object)['id' => '100', 'name' => '100 (win10-multifunction)', 'status' => 'stopped', 'type' => 'qemu', 'cpu' => 0, 'mem' => 0, 'maxmem' => 8.58, 'maxdisk' => 107.37, 'uptime' => '-', 'host_cpu' => 0, 'host_mem' => 0],
                    (object)['id' => '101', 'name' => '101 (win10in02)', 'status' => 'running', 'type' => 'qemu', 'cpu' => 0.25, 'mem' => 2.15, 'maxmem' => 4.29, 'maxdisk' => 536.87, 'uptime' => '5d 2h', 'host_cpu' => 8, 'host_mem' => 6],
                    (object)['id' => '102', 'name' => '102 (win10in01)', 'status' => 'running', 'type' => 'qemu', 'cpu' => 0.02, 'mem' => 1.5, 'maxmem' => 8.58, 'maxdisk' => 107.37, 'uptime' => '1h 30m', 'host_cpu' => 1, 'host_mem' => 4],
                    (object)['id' => '103', 'name' => '103 (ubuntu-24)', 'status' => 'stopped', 'type' => 'qemu', 'cpu' => 0, 'mem' => 0, 'maxmem' => 17.17, 'maxdisk' => 536.87, 'uptime' => '-', 'host_cpu' => 0, 'host_mem' => 0],
                ];
                break;
            case 'sekupang':
                $allVms = [
                    (object)['id' => '100', 'name' => '100 (win10-multifunction)', 'status' => 'running', 'type' => 'qemu', 'cpu' => 0.35, 'mem' => 3.8, 'maxmem' => 8.58, 'maxdisk' => 107.37, 'uptime' => '3d 12h', 'host_cpu' => 8, 'host_mem' => 10],
                    (object)['id' => '101', 'name' => '101 (win10in02)', 'status' => 'running', 'type' => 'qemu', 'cpu' => 0.10, 'mem' => 1.8, 'maxmem' => 4.29, 'maxdisk' => 214.74, 'uptime' => '3d 12h', 'host_cpu' => 4, 'host_mem' => 5],
                    (object)['id' => '102', 'name' => '102 (win10in01)', 'status' => 'stopped', 'type' => 'qemu', 'cpu' => 0, 'mem' => 0, 'maxmem' => 8.58, 'maxdisk' => 107.37, 'uptime' => '-', 'host_cpu' => 0, 'host_mem' => 0],
                    (object)['id' => '103', 'name' => '103 (ubuntu-24)', 'status' => 'running', 'type' => 'qemu', 'cpu' => 0.65, 'mem' => 10.5, 'maxmem' => 17.17, 'maxdisk' => 536.87, 'uptime' => '20d 5h', 'host_cpu' => 20, 'host_mem' => 20],
                ];
                break;
            case 'ags':
            default:
                $allVms = [
                    (object)['id' => '100', 'name' => '100 (win10-multifunction)', 'status' => 'running', 'type' => 'qemu', 'cpu' => 0.15, 'mem' => 3.5, 'maxmem' => 8.58, 'maxdisk' => 107.37, 'uptime' => '5d 1h', 'host_cpu' => 4, 'host_mem' => 10],
                    (object)['id' => '101', 'name' => '101 (win10in02)', 'status' => 'running', 'type' => 'qemu', 'cpu' => 0.05, 'mem' => 1.5, 'maxmem' => 4.29, 'maxdisk' => 53.68, 'uptime' => '12d 2h', 'host_cpu' => 2, 'host_mem' => 5],
                    (object)['id' => '102', 'name' => '102 (win10in01)', 'status' => 'stopped', 'type' => 'qemu', 'cpu' => 0, 'mem' => 0, 'maxmem' => 8.58, 'maxdisk' => 107.37, 'uptime' => '-', 'host_cpu' => 0, 'host_mem' => 0],
                    (object)['id' => '103', 'name' => '103 (ubuntu-24)', 'status' => 'running', 'type' => 'qemu', 'cpu' => 0.25, 'mem' => 5.5, 'maxmem' => 17.17, 'maxdisk' => 214.74, 'uptime' => '1d 1h', 'host_cpu' => 6, 'host_mem' => 12],
                ];
                break;
        }

        // Add extra items for every location (LXC, Node, SDN, Storage)
        $extraItems = [
            (object)['id' => '6690', 'name' => '6690 (vpn-site-to-site)', 'status' => 'running', 'type' => 'lxc', 'cpu' => 0.02, 'mem' => 0.5, 'maxmem' => 1.0, 'maxdisk' => 20.0, 'uptime' => '45d 12h', 'host_cpu' => 1, 'host_mem' => 2],
            (object)['id' => 'pve', 'name' => 'pve', 'status' => 'online', 'type' => 'node', 'cpu' => 0.20, 'mem' => 64.0, 'maxmem' => 128.0, 'maxdisk' => 1000.0, 'uptime' => '120d 2h', 'host_cpu' => 20, 'host_mem' => 50],
            (object)['id' => 'sdn', 'name' => 'localnetwork (pve)', 'status' => 'active', 'type' => 'sdn', 'cpu' => 0, 'mem' => 0, 'maxmem' => 0, 'maxdisk' => 0, 'uptime' => '-', 'host_cpu' => 0, 'host_mem' => 0],
            (object)['id' => 'local', 'name' => 'local', 'status' => 'active', 'type' => 'storage', 'cpu' => 0, 'mem' => 0, 'maxmem' => 0, 'maxdisk' => 100.0, 'uptime' => '-', 'host_cpu' => 0, 'host_mem' => 0],
            (object)['id' => 'local-lvm', 'name' => 'local-lvm', 'status' => 'active', 'type' => 'storage', 'cpu' => 0, 'mem' => 0, 'maxmem' => 0, 'maxdisk' => 900.0, 'uptime' => '-', 'host_cpu' => 0, 'host_mem' => 0],
        ];

        $vms = collect($allVms)->merge($extraItems)->sortBy(function($item) {
            $order = ['lxc' => 0, 'qemu' => 1, 'node' => 2, 'sdn' => 3, 'storage' => 4];
            return $order[$item->type] ?? 99;
        });
        
        // Dummy data for the datacenter dashboard summary
        $summary = [
            'cpu_usage' => $vms->whereIn('type', ['qemu', 'lxc'])->where('status', 'running')->avg('cpu') * 100 ?: 0,
            'memory_usage' => $vms->whereIn('type', ['qemu', 'lxc'])->where('status', 'running')->sum('mem') / ($vms->whereIn('type', ['qemu', 'lxc'])->sum('maxmem') ?: 1) * 100,
            'storage_usage' => 70,
            'running_vms' => $vms->where('type', 'qemu')->where('status', 'running')->count(),
            'stopped_vms' => $vms->where('type', 'qemu')->where('status', 'stopped')->count(),
            'total_vms' => $vms->where('type', 'qemu')->count(),
            'lxc_running' => $vms->where('type', 'lxc')->where('status', 'running')->count(),
            'lxc_stopped' => $vms->where('type', 'lxc')->where('status', 'stopped')->count(),
            'total_lxc' => $vms->where('type', 'lxc')->count(),
            'online_nodes' => $vms->where('type', 'node')->where('status', 'online')->count(),
            'offline_nodes' => $vms->where('type', 'node')->where('status', 'offline')->count(),
            'total_storage' => $vms->where('type', 'storage')->count(),
        ];

        return view('proxmox.datacenter', compact('location', 'summary', 'nodeName', 'vms'));
    }

    public function vmDetail($location, $vm_id)
    {
        // Dummy data for VM Detail
        $vm = (object)[
            'id' => $vm_id,
            'name' => 'VM-' . $vm_id,
            'node' => 'pve-' . $location,
            'status' => 'running',
            'uptime' => '10 days, 2 hours',
            'cpu_usage' => 50,
            'cpu_cores' => 4,
            'memory_usage_percent' => 50,
            'memory_usage_gb' => 4,
            'memory_total_gb' => 8,
            'disk_total_gb' => 100,
            'disk_usage_gb' => 60,
            'network_in' => '1.2 GB',
            'network_out' => '500 MB',
            'ip_address' => '192.168.1.' . rand(10, 255),
            'os_type' => str_contains($vm_id, 'win') ? 'windows' : 'linux',
        ];

        return view('proxmox.vm-detail', compact('location', 'vm'));
    }
    public function storage() { return view('proxmox.storage'); }
    public function vms() { return view('proxmox.vms'); }
    public function memory() { return view('proxmox.memory'); }
}
