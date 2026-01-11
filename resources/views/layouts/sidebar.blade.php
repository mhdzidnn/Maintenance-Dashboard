<aside x-data="{
    openSections: JSON.parse(localStorage.getItem('sidebar_sections')) || [],
    toggleSection(section) {
        if (this.openSections.includes(section)) {
            this.openSections = this.openSections.filter(s => s !== section);
        } else {
            this.openSections.push(section);
        }
        localStorage.setItem('sidebar_sections', JSON.stringify(this.openSections));
    }
}"
    class="w-64 bg-slate-900 border-r border-slate-800 flex flex-col h-full transition-all duration-300">
    <!-- Logo Section -->
    <div
        class="p-6 flex items-center space-x-4 border-b border-white/5 bg-slate-900/50 backdrop-blur-xl sticky top-0 z-10">
        <div
            class="w-11 h-11 rounded-xl bg-white p-1 flex items-center justify-center shadow-[0_0_20px_rgba(59,130,246,0.15)] border border-white/10 group-hover:scale-105 transition-all duration-500">
            <img src="{{ asset('img/persero batam.jpeg') }}" class="w-full h-full object-contain"
                alt="IT Persero Batam Logo">
        </div>
        <div class="flex flex-col justify-center">
            <span class="text-base font-black tracking-tight text-white uppercase leading-none">IT PERSERO</span>
            <div class="flex items-center space-x-1.5 mt-1">
                <span class="text-base font-black tracking-tight text-white uppercase leading-none">BATAM</span>
                <div class="w-1.5 h-1.5 rounded-full bg-blue-500 shadow-[0_0_8px_rgba(59,130,246,0.5)] animate-pulse">
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Section -->
    <nav class="flex-1 px-3 space-y-1.5 mt-6 overflow-y-auto scrollbar-hide">
        <!-- Dashboard Link -->
        <a href="{{ route('dashboard') }}"
            class="group relative flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-blue-600/10 text-blue-400' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
            @if (request()->routeIs('dashboard'))
                <div
                    class="absolute left-0 w-1 h-6 bg-blue-500 rounded-r-full shadow-[2px_0_10px_rgba(59,130,246,0.5)]">
                </div>
            @endif
            <i data-lucide="layout-dashboard"
                class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-blue-400' : 'text-slate-500 group-hover:text-blue-400' }} transition-colors"></i>
            <span class="font-semibold text-sm">Dashboard</span>
        </a>

        @php
            $proxmoxLocs = [
                ['id' => 'ags', 'name' => 'Proxmox AGS', 'icon' => 'activity'],
                ['id' => 'pusat', 'name' => 'Proxmox Kantor Pusat', 'icon' => 'activity'],
                ['id' => 'punggur', 'name' => 'Proxmox Punggur', 'icon' => 'activity'],
                ['id' => 'sekupang', 'name' => 'Proxmox Sekupang', 'icon' => 'activity'],
            ];
            $pveItems = [
                ['id' => '6690', 'name' => '6690 (Vpn-site-to-site)', 'type' => 'lxc'],
                ['id' => '100', 'name' => '100 (win10-multifunction)', 'type' => 'qemu'],
                ['id' => '101', 'name' => '101 (win10in02)', 'type' => 'qemu'],
                ['id' => '102', 'name' => '102 (win10in01)', 'type' => 'qemu'],
                ['id' => '103', 'name' => '103 (ubuntu-24)', 'type' => 'qemu'],
                ['id' => 'localnetwork', 'name' => 'localnetwork (pve)', 'type' => 'sdn'],
                ['id' => 'local', 'name' => 'local (pve)', 'type' => 'storage'],
                ['id' => 'local-lvm', 'name' => 'local-lvm (pve)', 'type' => 'storage'],
            ];
        @endphp

        <div class="pt-4 pb-2 px-4">
            <span class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500/80">Infrastructure</span>
        </div>

        @foreach ($proxmoxLocs as $loc)
            <div class="space-y-1">
                <button @click="toggleSection('proxmox_{{ $loc['id'] }}')"
                    class="w-full flex items-center justify-between px-4 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800/50 hover:text-white transition-all group">
                    <div class="flex items-center space-x-3">
                        <i data-lucide="{{ $loc['icon'] }}"
                            class="w-5 h-5 {{ in_array($loc['id'], ['ags', 'punggur']) ? 'text-blue-500' : (in_array($loc['id'], ['pusat', 'sekupang']) ? 'text-amber-500' : 'text-slate-500') }} group-hover:text-blue-400"></i>
                        <span class="font-semibold text-[13px]">{{ $loc['name'] }}</span>
                    </div>
                    <i data-lucide="chevron-right" class="w-4 h-4 text-slate-600 transition-transform duration-300"
                        :class="openSections.includes('proxmox_{{ $loc['id'] }}') ? 'rotate-90 text-slate-400' : ''"></i>
                </button>

                <div x-show="openSections.includes('proxmox_{{ $loc['id'] }}')" x-collapse
                    class="ml-6 pl-4 border-l border-slate-800/80 space-y-1 mt-1">

                    <!-- Datacenter Dashboard Link -->
                    <a href="{{ route('proxmox.datacenter', ['location' => $loc['id']]) }}"
                        class="group flex items-center justify-between px-3 py-2 rounded-lg transition-all {{ request()->fullUrlIs(route('proxmox.datacenter', ['location' => $loc['id']])) ? 'bg-blue-600/10 text-blue-400 font-bold' : 'text-slate-500 hover:bg-slate-800/40 hover:text-slate-300' }}">
                        <div class="flex items-center space-x-2">
                            <i data-lucide="activity" class="w-4 h-4"></i>
                            <span class="text-xs">Datacenter Summary</span>
                        </div>
                    </a>

                    <!-- pve Node Item -->
                    <div class="space-y-1">
                        <button @click="toggleSection('proxmox_{{ $loc['id'] }}_pve')"
                            class="w-full flex items-center justify-between px-3 py-2 rounded-lg text-slate-500 hover:text-slate-300 transition-all group text-xs font-medium">
                            <div class="flex items-center space-x-2">
                                <i data-lucide="database" class="w-4 h-4"></i>
                                <span>pve</span>
                            </div>
                            <i data-lucide="chevron-right" class="w-3 h-3 transition-transform duration-200"
                                :class="openSections.includes('proxmox_{{ $loc['id'] }}_pve') ? 'rotate-90' : ''"></i>
                        </button>

                        <div x-show="openSections.includes('proxmox_{{ $loc['id'] }}_pve')" x-collapse
                            class="ml-3 pl-4 border-l border-slate-800/50 space-y-0.5 mt-1">
                            @foreach ($pveItems as $item)
                                <a href="{{ route('proxmox.vm_detail', ['location' => $loc['id'], 'vm_id' => $item['id']]) }}"
                                    class="group flex items-center space-x-2 py-1.5 px-3 text-[11px] rounded-lg transition-all {{ request()->routeIs('proxmox.vm_detail') && request('vm_id') == $item['id'] && request('location') == $loc['id'] ? 'bg-blue-600/10 text-blue-400 font-bold' : 'text-slate-500/80 hover:text-blue-400 hover:bg-slate-800/30' }}">
                                    @php
                                        $vmIcon = 'monitor';
                                        if ($item['type'] == 'lxc') {
                                            $vmIcon = 'container';
                                        } elseif ($item['type'] == 'storage') {
                                            $vmIcon = 'hard-drive';
                                        } elseif ($item['type'] == 'sdn') {
                                            $vmIcon = 'network';
                                        }
                                    @endphp
                                    <i data-lucide="{{ $vmIcon }}"
                                        class="w-3.5 h-3.5 opacity-50 group-hover:opacity-100"></i>
                                    <span>{{ $item['name'] }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="pt-6 pb-2 px-4">
            <span class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500/80">Services</span>
        </div>

        <!-- Nextcloud Section -->
        <div class="space-y-1">
            <button @click="toggleSection('nextcloud')"
                class="w-full flex items-center justify-between px-4 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800/50 hover:text-white transition-all group">
                <div class="flex items-center space-x-3">
                    <i data-lucide="cloud" class="w-5 h-5 text-emerald-500/80 group-hover:text-emerald-400"></i>
                    <span class="font-semibold text-[13px]">Nextcloud Hub</span>
                </div>
                <i data-lucide="chevron-right" class="w-4 h-4 text-slate-600 transition-transform duration-300"
                    :class="openSections.includes('nextcloud') ? 'rotate-90 text-slate-400' : ''"></i>
            </button>
            <div x-show="openSections.includes('nextcloud')" x-collapse
                class="ml-6 pl-4 border-l border-slate-800/80 space-y-1 mt-1">
                <a href="{{ route('nextcloud.overview') }}"
                    class="block py-2 px-3 text-xs rounded-lg {{ request()->routeIs('nextcloud.overview') ? 'bg-emerald-600/10 text-emerald-400 font-bold' : 'text-slate-500 hover:text-emerald-400 hover:bg-emerald-600/5' }}">Overview</a>
                <a href="{{ route('nextcloud.users') }}"
                    class="block py-2 px-3 text-xs rounded-lg {{ request()->routeIs('nextcloud.users') ? 'bg-emerald-600/10 text-emerald-400 font-bold' : 'text-slate-500 hover:text-emerald-400 hover:bg-emerald-600/5' }}">Identity</a>
                <a href="{{ route('nextcloud.storage') }}"
                    class="block py-2 px-3 text-xs rounded-lg {{ request()->routeIs('nextcloud.storage') ? 'bg-emerald-600/10 text-emerald-400 font-bold' : 'text-slate-500 hover:text-emerald-400 hover:bg-emerald-600/5' }}">Filesystem</a>
            </div>
        </div>

        <!-- System Settings Section -->
        <div class="space-y-1">
            <button @click="toggleSection('system')"
                class="w-full flex items-center justify-between px-4 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800/50 hover:text-white transition-all group">
                <div class="flex items-center space-x-3">
                    <i data-lucide="cog" class="w-5 h-5 text-slate-500 group-hover:text-amber-400"></i>
                    <span class="font-semibold text-[13px]">System Tuning</span>
                </div>
                <i data-lucide="chevron-right" class="w-4 h-4 text-slate-600 transition-transform duration-300"
                    :class="openSections.includes('system') ? 'rotate-90 text-slate-400' : ''"></i>
            </button>
            <div x-show="openSections.includes('system')" x-collapse
                class="ml-6 pl-4 border-l border-slate-800/80 space-y-1 mt-1">
                <a href="{{ route('system.alerts') }}"
                    class="block py-2 px-3 text-xs rounded-lg {{ request()->routeIs('system.alerts') ? 'bg-amber-600/10 text-amber-400 font-bold' : 'text-slate-500 hover:text-amber-400 hover:bg-amber-600/5' }}">Global
                    Alerts</a>
                <a href="{{ route('system.logs') }}"
                    class="block py-2 px-3 text-xs rounded-lg {{ request()->routeIs('system.logs') ? 'bg-amber-600/10 text-amber-400 font-bold' : 'text-slate-500 hover:text-amber-400 hover:bg-amber-600/5' }}">Audit
                    Logs</a>
            </div>
        </div>
    </nav>

    <!-- Profile & Session -->
    <div class="p-4 bg-slate-900/50 border-t border-white/5 backdrop-blur-lg mt-auto">
        <div class="flex items-center justify-between px-2">
            <div class="flex items-center space-x-3">
                <div
                    class="w-10 h-10 rounded-xl bg-gradient-to-br from-slate-800 to-slate-900 flex items-center justify-center border border-white/5 shadow-inner">
                    <i data-lucide="shield" class="w-5 h-5 text-blue-500/80"></i>
                </div>
                <div class="flex flex-col">
                    <span
                        class="text-[13px] font-bold text-slate-200 truncate max-w-[100px]">{{ session('user_name', 'Admin') }}</span>
                    <span class="text-[10px] text-slate-500 uppercase font-black tracking-wider">Superuser</span>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST" id="logout-form">
                @csrf
                <button type="submit" title="Logout"
                    class="p-2.5 rounded-xl text-slate-500 hover:text-white hover:bg-red-500 shadow-sm hover:shadow-red-500/20 transition-all duration-300 group ring-1 ring-white/5 bg-slate-800/50">
                    <i data-lucide="log-out" class="w-4 h-4 group-hover:scale-110 transition-transform"></i>
                </button>
            </form>
        </div>
    </div>
</aside>
