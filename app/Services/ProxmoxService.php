<?php

namespace App\Services;

use App\Models\ProxmoxNode;
use App\Models\ProxmoxVm;
use App\Models\Site;
use Illuminate\Support\Facades\Cache;

class ProxmoxService
{
    /**
     * Get summary of all sites for the dashboard.
     */
    public function getGlobalSummary()
    {
        // TODO: Ganti dengan call API real jika dikonfigurasi.
        // Untuk saat ini, ambil data dari database.
        return Site::with(['thresholdAlert'])->get()->map(function ($site) {
            $nodes = ProxmoxNode::where('location', $site->key)->get();
            $vms = ProxmoxVm::whereIn('proxmox_node_id', $nodes->pluck('id'))->get();

            return [
                'site' => $site,
                'nodes_count' => $nodes->count(),
                'vms_count' => $vms->count(),
                'vms_running' => $vms->where('status', 'running')->count(),
                'cpu_avg' => $nodes->avg('cpu_usage') ?? 0,
                'mem_avg' => $nodes->avg('memory_usage') ?? 0,
            ];
        });
    }

    /**
     * Get nodes for a specific location.
     */
    public function getNodesByLocation($location)
    {
        // TODO: Ganti dengan call API real.
        return ProxmoxNode::where('location', $location)->get();
    }

    /**
     * Get VMs for a specific node/location.
     */
    public function getVmsByLocation($location)
    {
        // TODO: Ganti dengan call API real.
        $nodeIds = ProxmoxNode::where('location', $location)->pluck('id');
        return ProxmoxVm::whereIn('proxmox_node_id', $nodeIds)->get();
    }

    /**
     * Get details for a specific VM.
     */
    public function getVmDetail($location, $vmId)
    {
        // TODO: Ganti dengan call API real.
        return ProxmoxVm::where('vm_id', $vmId)
            ->whereHas('node', function ($q) use ($location) {
                $q->where('location', $location);
            })->first();
    }
}
