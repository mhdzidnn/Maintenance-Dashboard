<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProxmoxController extends Controller
{
    protected $proxmoxService;

    public function __construct(\App\Services\ProxmoxService $proxmoxService)
    {
        $this->proxmoxService = $proxmoxService;
    }

    public function index() { return view('proxmox.index'); }

    public function nodes($location = 'ags') 
    { 
        $title = 'Proxmox ' . strtoupper($location);
        $vms = $this->proxmoxService->getVmsByLocation($location);

        // Check for resource limits and generate notifications
        $notifications = [];
        // Fetch threshold for this location
        $site = \App\Models\Site::where('key', $location)->first();
        $threshold = $site ? $site->thresholdAlert : null;

        foreach ($vms as $vm) {
            if ($vm->status !== 'running') continue;

            $cpuLimit = $threshold->cpu_limit ?? 80;
            $memLimit = $threshold->mem_limit ?? 80;

            if ($vm->cpu_usage_percent > $cpuLimit) {
                $notifications[] = [
                    'id' => "alert_cpu_{$vm->vm_id}_{$location}",
                    'type' => 'warning',
                    'title' => 'High CPU Usage',
                    'message' => "VM <strong>{$vm->name}</strong> is using <strong>{$vm->cpu_usage_percent}%</strong> CPU.",
                    'node' => $vm->node->name ?? 'unknown'
                ];
            }

            if ($vm->memory_usage_percent > $memLimit) {
                $notifications[] = [
                    'id' => "alert_mem_{$vm->vm_id}_{$location}",
                    'type' => 'warning',
                    'title' => 'High Memory Usage',
                    'message' => "VM <strong>{$vm->name}</strong> is using <strong>{$vm->memory_usage_percent}%</strong> Memory.",
                    'node' => $vm->node->name ?? 'unknown'
                ];
            }
        }

        return view('proxmox.nodes', compact('vms', 'title', 'location', 'notifications')); 
    }

    public function datacenter($location = 'ags')
    {
        $nodeName = 'pve-' . $location;
        $vms = $this->proxmoxService->getVmsByLocation($location);
        $nodes = $this->proxmoxService->getNodesByLocation($location);

        // Map to summary structure for view compatibility
        $summary = [
            'cpu_usage' => $vms->where('status', 'running')->avg('cpu_usage_percent') ?: 0,
            'memory_usage' => $vms->where('status', 'running')->avg('memory_usage_percent') ?: 0,
            'storage_usage' => $nodes->avg('disk_usage') ?: 0,
            'running_vms' => $vms->where('type', 'qemu')->where('status', 'running')->count(),
            'stopped_vms' => $vms->where('type', 'qemu')->where('status', 'stopped')->count(),
            'total_vms' => $vms->where('type', 'qemu')->count(),
            'lxc_running' => $vms->where('type', 'lxc')->where('status', 'running')->count(),
            'lxc_stopped' => $vms->where('type', 'lxc')->where('status', 'stopped')->count(),
            'total_lxc' => $vms->where('type', 'lxc')->count(),
            'online_nodes' => $nodes->where('status', 'online')->count(),
            'offline_nodes' => $nodes->where('status', 'offline')->count(),
            'total_storage' => 1, // Placeholder for storage count
        ];

        return view('proxmox.datacenter', compact('location', 'summary', 'nodeName', 'vms'));
    }

    public function vmDetail($location, $vm_id)
    {
        $vm = $this->proxmoxService->getVmDetail($location, $vm_id);

        if (!$vm) {
            abort(404, "VM $vm_id not found at $location");
        }

        return view('proxmox.vm-detail', compact('location', 'vm'));
    }

    public function storageDetail($location, $id)
    {
        $nodeName = 'pve-' . $location;
        // Placeholder data for now
        $storage = (object) [
            'id' => $id,
            'name' => $id,
            'node' => $nodeName,
            'status' => 'online',
            'type' => 'dir',
            'content' => 'images, iso, backup',
            'total_gb' => 100,
            'used_gb' => 45,
            'free_gb' => 55,
            'usage_percent' => 45
        ];

        return view('proxmox.storage-detail', compact('location', 'storage', 'nodeName'));
    }

    public function networkDetail($location, $id)
    {
        $nodeName = 'pve-' . $location;
        // Placeholder data for now
        $network = (object) [
            'id' => $id,
            'name' => $id,
            'node' => $nodeName,
            'status' => 'active',
            'type' => 'bridge',
            'ip_address' => '10.10.10.1/24',
            'bridge_ports' => 'eth0',
            'vlan_aware' => 'No'
        ];

        return view('proxmox.network-detail', compact('location', 'network', 'nodeName'));
    }

    public function storage() { return view('proxmox.storage'); }
    public function vms() { return view('proxmox.vms'); }
    public function memory() { return view('proxmox.memory'); }
}
