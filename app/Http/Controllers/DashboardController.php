<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Same VM data as ProxmoxController – single source of truth
        $locationData = [
            'ags' => [
                'name'  => 'AGS',
                'vms'   => [
                    (object)['status' => 'running', 'type' => 'qemu', 'cpu_usage_percent' => 15, 'memory_usage_percent' => 30, 'formatted_uptime' => '5d 1h 30m'],
                    (object)['status' => 'running', 'type' => 'qemu', 'cpu_usage_percent' => 5,  'memory_usage_percent' => 20, 'formatted_uptime' => '12d 2h 10m'],
                    (object)['status' => 'stopped', 'type' => 'qemu', 'cpu_usage_percent' => 0,  'memory_usage_percent' => 0,  'formatted_uptime' => null],
                    (object)['status' => 'running', 'type' => 'qemu', 'cpu_usage_percent' => 25, 'memory_usage_percent' => 35, 'formatted_uptime' => '1d 1h 0m'],
                    (object)['status' => 'running', 'type' => 'lxc',  'cpu_usage_percent' => 2,  'memory_usage_percent' => 50, 'formatted_uptime' => '45d 12h'],
                ],
            ],
            'pusat' => [
                'name'  => 'Kantor Pusat',
                'vms'   => [
                    (object)['status' => 'running', 'type' => 'qemu', 'cpu_usage_percent' => 85, 'memory_usage_percent' => 90, 'formatted_uptime' => '10d 2h 30m'],
                    (object)['status' => 'running', 'type' => 'qemu', 'cpu_usage_percent' => 60, 'memory_usage_percent' => 75, 'formatted_uptime' => '15d 5h 10m'],
                    (object)['status' => 'running', 'type' => 'qemu', 'cpu_usage_percent' => 45, 'memory_usage_percent' => 50, 'formatted_uptime' => '2d 1h 0m'],
                    (object)['status' => 'running', 'type' => 'qemu', 'cpu_usage_percent' => 95, 'memory_usage_percent' => 92, 'formatted_uptime' => '30d 12h 0m'],
                    (object)['status' => 'running', 'type' => 'lxc',  'cpu_usage_percent' => 2,  'memory_usage_percent' => 50, 'formatted_uptime' => '45d 12h'],
                ],
            ],
            'punggur' => [
                'name'  => 'Punggur',
                'vms'   => [
                    (object)['status' => 'stopped', 'type' => 'qemu', 'cpu_usage_percent' => 0,  'memory_usage_percent' => 0,  'formatted_uptime' => null],
                    (object)['status' => 'running', 'type' => 'qemu', 'cpu_usage_percent' => 15, 'memory_usage_percent' => 30, 'formatted_uptime' => '5d 2h 10m'],
                    (object)['status' => 'running', 'type' => 'qemu', 'cpu_usage_percent' => 2,  'memory_usage_percent' => 15, 'formatted_uptime' => '1h 30m'],
                    (object)['status' => 'stopped', 'type' => 'qemu', 'cpu_usage_percent' => 0,  'memory_usage_percent' => 0,  'formatted_uptime' => null],
                    (object)['status' => 'running', 'type' => 'lxc',  'cpu_usage_percent' => 2,  'memory_usage_percent' => 50, 'formatted_uptime' => '45d 12h'],
                ],
            ],
            'sekupang' => [
                'name'  => 'Sekupang',
                'vms'   => [
                    (object)['status' => 'running', 'type' => 'qemu', 'cpu_usage_percent' => 35, 'memory_usage_percent' => 45, 'formatted_uptime' => '3d 12h 0m'],
                    (object)['status' => 'running', 'type' => 'qemu', 'cpu_usage_percent' => 10, 'memory_usage_percent' => 25, 'formatted_uptime' => '3d 12h 0m'],
                    (object)['status' => 'stopped', 'type' => 'qemu', 'cpu_usage_percent' => 0,  'memory_usage_percent' => 0,  'formatted_uptime' => null],
                    (object)['status' => 'running', 'type' => 'qemu', 'cpu_usage_percent' => 65, 'memory_usage_percent' => 70, 'formatted_uptime' => '20d 5h 0m'],
                    (object)['status' => 'running', 'type' => 'lxc',  'cpu_usage_percent' => 2,  'memory_usage_percent' => 50, 'formatted_uptime' => '45d 12h'],
                ],
            ],
        ];

        $sites = [];
        foreach ($locationData as $locationKey => $data) {
            $vms        = collect($data['vms']);
            $runningVms = $vms->where('status', 'running');
            $totalVms   = $vms->count();
            $running    = $runningVms->count();
            $stopped    = $vms->where('status', 'stopped')->count();

            $avgCpu = $running > 0
                ? round($runningVms->avg('cpu_usage_percent'))
                : 0;
            $avgMem = $running > 0
                ? round($runningVms->avg('memory_usage_percent'))
                : 0;

            // Determine status: warning if any running VM has CPU or MEM > 80%
            $hasWarning = $runningVms->first(fn($vm) =>
                $vm->cpu_usage_percent > 80 || $vm->memory_usage_percent > 80
            ) !== null;

            // Longest uptime among running VMs (take first as representative)
            $uptime = $runningVms->first()?->formatted_uptime ?? '-';

            $sites[] = [
                'name'     => $data['name'],
                'location' => $locationKey,
                'status'   => $hasWarning ? 'warning' : 'online',
                'total'    => $totalVms,
                'running'  => $running,
                'stopped'  => $stopped,
                'cpu'      => $avgCpu,
                'mem'      => $avgMem,
                'uptime'   => $uptime,
            ];
        }

        return view('dashboard', compact('sites'));
    }
}
