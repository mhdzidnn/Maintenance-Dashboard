@extends('layouts.app')

@section('content')
<div class="p-8 space-y-6">
    {{-- Page Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-white uppercase tracking-tight">VM AGS</h1>
            <p class="text-slate-400 text-sm mt-1">Virtual Machines Management</p>
        </div>
        <div class="flex items-center space-x-2">
            <div class="px-4 py-2 bg-slate-800/50 rounded-xl border border-slate-700/50">
                <span class="text-xs text-slate-400 uppercase tracking-wider">Total VMs:</span>
                <span class="ml-2 text-lg font-bold text-white">{{ $vms->count() }}</span>
            </div>
        </div>
    </div>

    {{-- VM List --}}
    <div class="grid gap-4">
        @forelse($vms as $vm)
        <div class="bg-slate-800/40 backdrop-blur-xl border border-slate-700/50 rounded-2xl p-6 hover:border-blue-500/30 transition-all duration-300 hover:shadow-lg hover:shadow-blue-500/10">
            <div class="flex items-start justify-between mb-6">
                {{-- VM Info --}}
                <div class="flex items-start space-x-6">
                    {{-- VM Icon --}}
                    <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-blue-500/20 to-purple-500/20 border border-blue-500/30 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="monitor" class="w-8 h-8 text-blue-400"></i>
                    </div>

                    {{-- VM Details --}}
                    <div class="flex-1">
                        <div class="flex items-center space-x-3 mb-2">
                            <h3 class="text-xl font-bold text-white">{{ $vm->name }}</h3>
                            @if($vm->is_running)
                                <span class="px-3 py-1 bg-emerald-500/20 text-emerald-400 text-xs font-bold uppercase tracking-wider rounded-full border border-emerald-500/30 flex items-center space-x-1.5">
                                    <div class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></div>
                                    <span>Running</span>
                                </span>
                            @else
                                <span class="px-3 py-1 bg-red-500/20 text-red-400 text-xs font-bold uppercase tracking-wider rounded-full border border-red-500/30 flex items-center space-x-1.5">
                                    <div class="w-2 h-2 bg-red-400 rounded-full"></div>
                                    <span>Stopped</span>
                                </span>
                            @endif
                        </div>
                        <div class="flex items-center space-x-4 text-sm text-slate-400">
                            <span>
                                <span class="text-slate-500 uppercase text-xs">VM ID:</span>
                                <span class="font-mono font-bold text-blue-400 ml-1">{{ $vm->vm_id }}</span>
                            </span>
                            @if($vm->node)
                                <span>
                                    <span class="text-slate-500 uppercase text-xs">Node:</span>
                                    <span class="font-semibold text-slate-300 ml-1">{{ $vm->node->name }}</span>
                                </span>
                            @endif
                            <span>
                                <span class="text-slate-500 uppercase text-xs">OS:</span>
                                <span class="font-semibold text-slate-300 ml-1">{{ $vm->os_type }}</span>
                            </span>
                            @if($vm->formatted_uptime)
                                <span>
                                    <span class="text-slate-500 uppercase text-xs">Uptime:</span>
                                    <span class="font-semibold text-slate-300 ml-1">{{ $vm->formatted_uptime }}</span>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Quick Actions --}}
                <div class="flex flex-col space-y-2">
                    <button class="px-4 py-2 bg-blue-600/20 hover:bg-blue-600/30 text-blue-400 rounded-lg border border-blue-500/30 transition-all flex items-center space-x-2 text-sm font-semibold">
                        <i data-lucide="settings" class="w-4 h-4"></i>
                        <span>Manage</span>
                    </button>
                </div>
            </div>

            {{-- Resource Usage --}}
            <div class="grid grid-cols-3 gap-6">
                {{-- CPU Usage --}}
                <div class="bg-slate-900/50 rounded-xl p-4 border border-slate-700/30">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center space-x-2">
                            <i data-lucide="cpu" class="w-4 h-4 text-blue-400"></i>
                            <span class="text-xs text-slate-400 uppercase tracking-wider font-bold">CPU Usage</span>
                        </div>
                        <span class="text-sm font-bold text-white">{{ number_format($vm->cpu_usage_percent, 1) }}%</span>
                    </div>
                    <div class="w-full bg-slate-700/50 rounded-full h-2.5 overflow-hidden">
                        <div class="h-2.5 rounded-full transition-all duration-500 {{ $vm->cpu_usage_percent > 80 ? 'bg-gradient-to-r from-red-500 to-red-600' : ($vm->cpu_usage_percent > 50 ? 'bg-gradient-to-r from-yellow-500 to-orange-500' : 'bg-gradient-to-r from-blue-500 to-cyan-500') }}" 
                             style="width: {{ min($vm->cpu_usage_percent, 100) }}%"></div>
                    </div>
                    <div class="mt-2 text-xs text-slate-500">
                        {{ $vm->cpu_cores }} vCPU(s) @ {{ number_format($vm->cpu_usage_percent * $vm->cpu_cores / 100, 2) }} of {{ $vm->cpu_cores }} CPU
                    </div>
                </div>

                {{-- Memory Usage --}}
                <div class="bg-slate-900/50 rounded-xl p-4 border border-slate-700/30">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center space-x-2">
                            <i data-lucide="memory-stick" class="w-4 h-4 text-purple-400"></i>
                            <span class="text-xs text-slate-400 uppercase tracking-wider font-bold">Memory</span>
                        </div>
                        <span class="text-sm font-bold text-white">{{ number_format($vm->memory_usage_percent, 1) }}%</span>
                    </div>
                    <div class="w-full bg-slate-700/50 rounded-full h-2.5 overflow-hidden">
                        <div class="h-2.5 rounded-full transition-all duration-500 {{ $vm->memory_usage_percent > 80 ? 'bg-gradient-to-r from-red-500 to-red-600' : ($vm->memory_usage_percent > 50 ? 'bg-gradient-to-r from-yellow-500 to-orange-500' : 'bg-gradient-to-r from-purple-500 to-pink-500') }}" 
                             style="width: {{ min($vm->memory_usage_percent, 100) }}%"></div>
                    </div>
                    <div class="mt-2 text-xs text-slate-500">
                        {{ $vm->formatted_memory }}
                    </div>
                </div>

                {{-- Disk Usage --}}
                <div class="bg-slate-900/50 rounded-xl p-4 border border-slate-700/30">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center space-x-2">
                            <i data-lucide="hard-drive" class="w-4 h-4 text-emerald-400"></i>
                            <span class="text-xs text-slate-400 uppercase tracking-wider font-bold">Disk Size</span>
                        </div>
                        <span class="text-sm font-bold text-white">{{ number_format($vm->usage_gb) }} GB</span>
                    </div>
                    <div class="w-full bg-slate-700/50 rounded-full h-2.5 overflow-hidden">
                        <div class="h-2.5 rounded-full bg-gradient-to-r from-emerald-500 to-teal-500 transition-all duration-500" 
                             style="width: {{ min(($vm->usage_gb / 500) * 100, 100) }}%"></div>
                    </div>
                    <div class="mt-2 text-xs text-slate-500">
                        Allocated storage
                    </div>
                </div>
            </div>

            {{-- Last Synced --}}
            @if($vm->last_synced_at)
            <div class="mt-4 pt-4 border-t border-slate-700/30">
                <div class="flex items-center justify-between text-xs text-slate-500">
                    <span>Last synced: {{ $vm->last_synced_at->diffForHumans() }}</span>
                    <span class="text-slate-600">{{ $vm->last_synced_at->format('Y-m-d H:i:s') }}</span>
                </div>
            </div>
            @endif
        </div>
        @empty
        <div class="bg-slate-800/40 backdrop-blur-xl border border-slate-700/50 rounded-2xl p-12 text-center">
            <i data-lucide="inbox" class="w-16 h-16 text-slate-600 mx-auto mb-4"></i>
            <h3 class="text-xl font-bold text-slate-400 mb-2">No Virtual Machines Found</h3>
            <p class="text-slate-500">There are no VMs configured in the system.</p>
        </div>
        @endforelse
    </div>

    {{-- Statistics Cards --}}
    <div class="grid grid-cols-3 gap-4 mt-6">
        <div class="bg-gradient-to-br from-emerald-500/10 to-emerald-600/5 backdrop-blur-xl border border-emerald-500/30 rounded-2xl p-6">
            <div class="flex items-center space-x-3 mb-2">
                <div class="w-10 h-10 rounded-lg bg-emerald-500/20 flex items-center justify-center">
                    <i data-lucide="play-circle" class="w-5 h-5 text-emerald-400"></i>
                </div>
                <span class="text-xs text-emerald-400/70 uppercase tracking-wider font-bold">Running</span>
            </div>
            <p class="text-3xl font-black text-emerald-400">{{ $vms->where('is_running', true)->count() }}</p>
        </div>

        <div class="bg-gradient-to-br from-red-500/10 to-red-600/5 backdrop-blur-xl border border-red-500/30 rounded-2xl p-6">
            <div class="flex items-center space-x-3 mb-2">
                <div class="w-10 h-10 rounded-lg bg-red-500/20 flex items-center justify-center">
                    <i data-lucide="stop-circle" class="w-5 h-5 text-red-400"></i>
                </div>
                <span class="text-xs text-red-400/70 uppercase tracking-wider font-bold">Stopped</span>
            </div>
            <p class="text-3xl font-black text-red-400">{{ $vms->where('is_running', false)->count() }}</p>
        </div>

        <div class="bg-gradient-to-br from-blue-500/10 to-purple-600/5 backdrop-blur-xl border border-blue-500/30 rounded-2xl p-6">
            <div class="flex items-center space-x-3 mb-2">
                <div class="w-10 h-10 rounded-lg bg-blue-500/20 flex items-center justify-center">
                    <i data-lucide="hard-drive" class="w-5 h-5 text-blue-400"></i>
                </div>
                <span class="text-xs text-blue-400/70 uppercase tracking-wider font-bold">Total Storage</span>
            </div>
            <div class="flex items-baseline space-x-1">
                <p class="text-3xl font-black text-blue-400">{{ number_format($vms->sum('usage_gb')) }}</p>
                <span class="text-sm text-slate-400 font-semibold">GB</span>
            </div>
        </div>
    </div>
</div>
@endsection