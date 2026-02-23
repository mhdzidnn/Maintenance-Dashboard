@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div
                    class="w-12 h-12 rounded-xl bg-violet-500/10 text-violet-600 flex items-center justify-center border border-violet-500/20">
                    <i data-lucide="share-2" class="w-6 h-6"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">Network: {{ $network->name }}</h1>
                    <p class="text-slate-500">Node: {{ $network->node }} &bull; Status: <span
                            class="text-green-600 uppercase font-bold">{{ $network->status }}</span></p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('proxmox.datacenter', ['location' => $location]) }}"
                    class="px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-lg text-sm font-medium transition-colors">
                    Back to Datacenter
                </a>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Details -->
            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-800 mb-6 flex items-center">
                    <i data-lucide="info" class="w-5 h-5 mr-2 text-blue-500"></i>
                    Network Information
                </h2>
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-3 border-b border-slate-100">
                        <span class="text-slate-500">Type</span>
                        <span class="text-slate-900 font-mono">{{ $network->type }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-slate-100">
                        <span class="text-slate-500">IP Address</span>
                        <span class="text-slate-900 font-mono">{{ $network->ip_address }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-slate-100">
                        <span class="text-slate-500">Ports</span>
                        <span class="text-slate-900">{{ $network->bridge_ports }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3">
                        <span class="text-slate-500">VLAN Aware</span>
                        <span class="text-slate-900">{{ $network->vlan_aware }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
