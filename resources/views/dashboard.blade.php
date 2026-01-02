<x-app-layout>
    <div class="relative min-h-screen">
        <!-- Decorative Background Elements -->
        <div
            class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-blue-600/10 rounded-full blur-[120px] -z-10 animate-float">
        </div>
        <div class="absolute bottom-[10%] right-[-5%] w-[30%] h-[30%] bg-emerald-600/10 rounded-full blur-[100px] -z-10 animate-float"
            style="animation-delay: -3s"></div>

        <div class="space-y-4 relative z-10">
            <!-- Hero Node Header -->
            <div class="glass-card p-5 rounded-[2rem] border-white/5 overflow-hidden relative">
                <div class="absolute top-0 right-0 w-64 h-64 bg-blue-500/5 rounded-full blur-3xl -mr-32 -mt-32"></div>

                <div class="flex flex-col md:flex-row md:items-center justify-between relative z-10">
                    <div>
                        <div class="flex items-center space-x-3 mb-2">
                            <div
                                class="w-12 h-12 bg-blue-600/20 rounded-2xl flex items-center justify-center border border-blue-500/30">
                                <i data-lucide="server" class="w-6 h-6 text-blue-400"></i>
                            </div>
                            <h1 class="text-3xl font-black tracking-tight text-white uppercase">
                                PROXMOX NODE: <span class="text-gradient-blue italic">prox01</span>
                            </h1>
                        </div>
                        <div class="flex items-center space-x-4 mt-4">
                            <span
                                class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-black bg-emerald-500 text-white shadow-[0_0_20px_rgba(16,185,129,0.4)] animate-pulse">
                                <i data-lucide="shield-check" class="w-4 h-4 mr-2"></i>
                                SYSTEM ONLINE
                            </span>
                            <div class="h-4 w-[1px] bg-slate-700"></div>
                            <span class="text-sm font-bold text-slate-400 flex items-center">
                                <i data-lucide="clock" class="w-4 h-4 mr-2"></i>
                                Uptime: <span class="text-white ml-1">47 days, 8h</span>
                            </span>
                            <span class="text-sm font-bold text-slate-400 flex items-center">
                                <i data-lucide="activity" class="w-4 h-4 mr-2 ml-2"></i>
                                Load: <span class="text-white ml-1">0.32</span>
                            </span>
                        </div>
                    </div>
                    <div class="mt-6 md:mt-0 flex space-x-3">
                        <button
                            class="px-6 py-3 glass-morphism hover:bg-white/5 text-white rounded-2xl border border-white/10 flex items-center transition-all group font-bold text-sm">
                            <i data-lucide="file-text" class="w-4 h-4 mr-2 opacity-60"></i>
                            Logs
                        </button>
                        <button
                            class="px-6 py-3 bg-blue-600 hover:bg-blue-500 text-white rounded-2xl shadow-lg shadow-blue-600/20 flex items-center transition-all group font-bold text-sm">
                            <i data-lucide="settings"
                                class="w-4 h-4 mr-2 group-hover:rotate-90 transition-transform"></i>
                            Configuration
                        </button>
                    </div>
                </div>
            </div>

            <!-- Dashboard Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 pb-6">
                <!-- Top Row: Node Status & Nextcloud -->
                <div class="lg:col-span-8">
                    @php $node = \App\Models\Node::where('name', 'prox01')->first() ?? \App\Models\Node::first(); @endphp
                    <livewire:node-status-card :nodeId="$node->id ?? null" />
                </div>
                <div class="lg:col-span-4">
                    <livewire:nextcloud-overview />
                </div>

                <!-- Main Column: Storage & Trends (8/12) -->
                <div class="lg:col-span-8 space-y-4">
                    <div class="transition-all">
                        @php $storage = \App\Models\StorageHealth::where('name', 'LOCAL-LVM')->first() ?? \App\Models\StorageHealth::first(); @endphp
                        <livewire:storage-health-card :storageId="$storage->id ?? null" />
                    </div>

                    <div class="h-[240px] relative overflow-hidden">
                        <livewire:usage-trend-chart />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <livewire:v-m-usage-card />
                        <livewire:user-quota-warning />
                    </div>
                </div>

                <!-- Sidebar Column: Alerts, Stats & Actions (4/12) -->
                <div class="lg:col-span-4 space-y-4">
                    <livewire:system-alerts />
                    <livewire:recent-logins />
                    <livewire:quick-actions />
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Toast Container -->
    <div x-data="{ show: false, message: '' }"
        x-on:action-completed.window="show = true; message = $event.detail.message; setTimeout(() => show = false, 4000)"
        x-show="show" x-cloak x-transition:enter="transition ease-out duration-500"
        x-transition:enter-start="opacity-0 translate-y-12 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-4" class="fixed bottom-10 left-1/2 -translate-x-1/2 z-50">
        <div
            class="glass-morphism border-emerald-500/30 text-emerald-400 px-8 py-4 rounded-3xl shadow-2xl flex items-center space-x-4 border">
            <div class="w-10 h-10 bg-emerald-500/20 rounded-full flex items-center justify-center">
                <i data-lucide="check" class="w-5 h-5 text-emerald-400"></i>
            </div>
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest opacity-60">Success</p>
                <span class="font-bold text-sm tracking-tight" x-text="message"></span>
            </div>
        </div>
    </div>
</x-app-layout>
