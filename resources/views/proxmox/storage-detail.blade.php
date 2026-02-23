@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div
                    class="w-12 h-12 rounded-xl bg-amber-500/10 text-amber-600 flex items-center justify-center border border-amber-500/20">
                    <i data-lucide="hard-drive" class="w-6 h-6"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">Storage: {{ $storage->name }}</h1>
                    <p class="text-slate-500">Node: {{ $storage->node }} &bull; Status: <span
                            class="text-green-600 uppercase font-bold">{{ $storage->status }}</span></p>
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
                    Storage Information
                </h2>
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-3 border-b border-slate-100">
                        <span class="text-slate-500">Type</span>
                        <span class="text-slate-900 font-mono">{{ $storage->type }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-slate-100">
                        <span class="text-slate-500">Content</span>
                        <span class="text-slate-900">{{ $storage->content }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-slate-100">
                        <span class="text-slate-500">Total Capacity</span>
                        <span class="text-slate-900 font-mono">{{ $storage->total_gb }} GB</span>
                    </div>
                    <div class="flex justify-between items-center py-3">
                        <span class="text-slate-500">Active</span>
                        <span class="text-green-600">Yes</span>
                    </div>
                </div>
            </div>

            <!-- Resource Usage -->
            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-800 mb-6 flex items-center">
                    <i data-lucide="activity" class="w-5 h-5 mr-2 text-purple-500"></i>
                    Storage Usage
                </h2>
                <div class="space-y-6">
                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-slate-500 text-sm">Used Space</span>
                            <span class="text-slate-800 text-sm font-bold">{{ $storage->usage_percent }}%
                                ({{ $storage->used_gb }}GB of {{ $storage->total_gb }}GB)</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2.5">
                            <div class="bg-amber-500 h-2.5 rounded-full" style="width: {{ $storage->usage_percent }}%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
