<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $proxmoxService;

    public function __construct(\App\Services\ProxmoxService $proxmoxService)
    {
        $this->proxmoxService = $proxmoxService;
    }

    public function index()
    {
        $summaries = $this->proxmoxService->getGlobalSummary();

        $sites = $summaries->map(function ($item) {
            $site = $item['site'];
            $threshold = $site->thresholdAlert;

            // Determine status: warning if CPU or MEM > threshold set in Master Data
            $hasWarning = $item['cpu_avg'] > ($threshold->cpu_limit ?? 80) ||
                          $item['mem_avg'] > ($threshold->mem_limit ?? 80);

            // Fetch representative uptime if nodes exist
            $nodes = $this->proxmoxService->getNodesByLocation($site->key);
            $uptime = $nodes->first()?->uptime ?? '-';

            return [
                'name'     => $site->name,
                'location' => $site->key,
                'status'   => $hasWarning ? 'warning' : 'online',
                'total'    => $item['vms_count'],
                'running'  => $item['vms_running'],
                'stopped'  => $item['vms_count'] - $item['vms_running'],
                'cpu'      => round($item['cpu_avg']),
                'mem'      => round($item['mem_avg']),
                'uptime'   => $uptime,
            ];
        });

        return view('dashboard', compact('sites'));
    }
}
