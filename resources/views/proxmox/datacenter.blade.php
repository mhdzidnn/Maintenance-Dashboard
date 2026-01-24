@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Datacenter: {{ ucfirst($location) }}</h1>
                <p class="text-slate-500">Overview and Resource Usage for {{ $nodeName }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <div
                    class="px-3 py-1 bg-green-500/10 border border-green-500/20 text-green-400 rounded-lg text-sm font-medium flex items-center">
                    <i data-lucide="check-circle" class="w-4 h-4 mr-2"></i>
                    Cluster Healthy
                </div>
            </div>
        </div>

        <!-- Search Section (Simulated) -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-800 mb-4">Search & Summary</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div
                    class="bg-slate-50 p-4 rounded-xl border border-slate-200 hover:border-blue-500 transition-colors cursor-pointer group">
                    <div class="text-slate-500 text-sm mb-1 group-hover:text-blue-600">Virtual Machines</div>
                    <div class="text-3xl font-bold text-slate-800">{{ $summary['total_vms'] }}</div>
                    <div class="mt-2 flex items-center space-x-2 text-xs">
                        <span class="text-green-400">{{ $summary['running_vms'] }} Running</span>
                        <span class="text-slate-600">|</span>
                        <span class="text-red-400">{{ $summary['stopped_vms'] }} Stopped</span>
                    </div>
                </div>
                <div
                    class="bg-slate-50 p-4 rounded-xl border border-slate-200 hover:border-purple-500 transition-colors cursor-pointer group">
                    <div class="text-slate-500 text-sm mb-1 group-hover:text-purple-600">LXC Containers</div>
                    <div class="text-3xl font-bold text-slate-800">{{ $summary['total_lxc'] }}</div>
                    <div class="mt-2 flex items-center space-x-2 text-xs">
                        <span class="text-emerald-400">{{ $summary['lxc_running'] }} Running</span>
                        @if ($summary['lxc_stopped'] > 0)
                            <span class="text-slate-600">|</span>
                            <span class="text-red-400">{{ $summary['lxc_stopped'] }} Stopped</span>
                        @endif
                    </div>
                </div>
                <div
                    class="bg-slate-50 p-4 rounded-xl border border-slate-200 hover:border-emerald-500 transition-colors cursor-pointer group">
                    <div class="text-slate-500 text-sm mb-1 group-hover:text-emerald-600">Nodes</div>
                    <div class="text-3xl font-bold text-slate-800">{{ $summary['online_nodes'] }}</div>
                    <div class="mt-2 text-xs text-green-600">All nodes online</div>
                </div>
                <div
                    class="bg-slate-50 p-4 rounded-xl border border-slate-200 hover:border-amber-500 transition-colors cursor-pointer group">
                    <div class="text-slate-500 text-sm mb-1 group-hover:text-amber-600">Storage</div>
                    <div class="text-3xl font-bold text-slate-800">{{ $summary['total_storage'] }}</div>
                    <div class="mt-2 text-xs text-amber-600">{{ $summary['storage_usage'] }}% Global usage</div>
                </div>
            </div>

            <div class="relative">
                <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"></i>
                <input type="text" placeholder="Search for VM, LXC, Node, SDN or Storage..."
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 pl-12 pr-4 text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
            </div>
        </div>

        <!-- Datacenter Summary Table -->
        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
            <div class="p-6 border-b border-slate-100">
                <h2 class="text-lg font-semibold text-slate-800">Resource Summary</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Description
                            </th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Disk Usage
                            </th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Memory Usage
                            </th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">CPU Usage
                            </th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Uptime</th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Host CPU
                            </th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Host Memory
                            </th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($vms as $vm)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4">
                                    @php
                                        $icon = 'monitor';
                                        $label = 'qemu';
                                        $iconColor = 'text-blue-500';
                                        if ($vm->type == 'lxc') {
                                            $icon = 'container';
                                            $label = 'LXC Container';
                                            $iconColor = 'text-emerald-500';
                                        } elseif ($vm->type == 'node') {
                                            $icon = 'server';
                                            $label = 'Node';
                                            $iconColor = 'text-amber-500';
                                        } elseif ($vm->type == 'sdn') {
                                            $icon = 'network';
                                            $label = 'SDN';
                                            $iconColor = 'text-purple-500';
                                        } elseif ($vm->type == 'storage') {
                                            $icon = 'database';
                                            $label = 'Storage';
                                            $iconColor = 'text-pink-500';
                                        }
                                    @endphp
                                    <div class="flex items-center space-x-2">
                                        <i data-lucide="{{ $icon }}"
                                            class="w-4 h-4 {{ in_array($vm->status, ['running', 'online', 'active']) ? $iconColor : 'text-slate-400' }}"></i>
                                        <span class="text-xs font-semibold text-slate-600">{{ $label }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-slate-800">{{ $vm->name }}</div>
                                    <div class="text-[10px] text-slate-500 flex items-center space-x-2 mt-0.5">
                                        <span>ID: {{ $vm->id }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if (isset($vm->maxdisk) && $vm->maxdisk > 0 && !in_array($vm->type, ['lxc', 'sdn']))
                                        <div class="flex items-center space-x-2">
                                            <div class="w-16 bg-slate-200 rounded-full h-1.5 overflow-hidden">
                                                <div class="bg-amber-500 h-full" style="width: 60%"></div>
                                            </div>
                                            <span class="text-xs text-slate-600">{{ $vm->maxdisk }} GB</span>
                                        </div>
                                    @else
                                        <span class="text-slate-600">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if (isset($vm->maxmem) && $vm->maxmem > 0 && !in_array($vm->type, ['lxc', 'sdn']))
                                        <div class="text-sm text-slate-800">
                                            {{ $vm->mem }} GB / {{ $vm->maxmem }} GB
                                        </div>
                                        <div class="w-24 bg-slate-200 rounded-full h-1.5 mt-1 overflow-hidden">
                                            <div class="bg-purple-500 h-full"
                                                style="width: {{ ($vm->mem / $vm->maxmem) * 100 }}%"></div>
                                        </div>
                                    @else
                                        <span class="text-slate-600">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if (isset($vm->cpu) && in_array($vm->type, ['qemu', 'node']))
                                        <div class="flex items-center space-x-2">
                                            <span
                                                class="text-sm text-slate-800 font-mono">{{ number_format($vm->cpu * 100, 1) }}%</span>
                                            <div class="w-12 bg-slate-200 rounded-full h-1.5 overflow-hidden">
                                                <div class="bg-blue-500 h-full" style="width: {{ $vm->cpu * 100 }}%"></div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-slate-600">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="text-sm text-slate-600 font-mono">{{ !in_array($vm->type, ['lxc', 'sdn']) ? $vm->uptime ?? '-' : '-' }}</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600 font-mono">
                                    {{ !in_array($vm->type, ['lxc', 'sdn']) && isset($vm->host_cpu) && $vm->host_cpu > 0 ? $vm->host_cpu . ' %' : '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600 font-mono">
                                    {{ !in_array($vm->type, ['lxc', 'sdn']) && isset($vm->host_mem) && $vm->host_mem > 0 ? $vm->host_mem . ' %' : '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    @if (!in_array($vm->type, ['lxc', 'sdn']))
                                        <span
                                            class="px-2 py-1 text-[10px] font-bold rounded-full uppercase
                                {{ in_array($vm->status, ['running', 'online', 'active']) ? 'bg-green-500/10 text-green-600 border border-green-500/20' : 'bg-slate-100 text-slate-500 border border-slate-200' }}">
                                            {{ $vm->status }}
                                        </span>
                                    @else
                                        <span class="text-slate-600">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
