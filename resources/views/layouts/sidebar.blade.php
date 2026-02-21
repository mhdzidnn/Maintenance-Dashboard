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
    class="w-64 brand-gradient border-r border-white/10 flex flex-col h-full transition-all duration-300">
    <!-- Logo Section -->
    <div class="p-6 flex items-center space-x-4 border-b border-white/10 bg-white/5 backdrop-blur-xl sticky top-0 z-10">
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
    <nav class="flex-1 px-3 space-y-1.5 mt-6 overflow-y-auto scrollbar-thin-white">
        <!-- Dashboard Link -->
        <a href="{{ route('dashboard') }}"
            class="group relative flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-white/10 text-white shadow-sm ring-1 ring-white/20' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
            @if (request()->routeIs('dashboard'))
                <div
                    class="absolute left-0 w-1 h-6 bg-blue-500 rounded-r-full shadow-[2px_0_10px_rgba(59,130,246,0.5)]">
                </div>
            @endif
            <i data-lucide="layout-dashboard"
                class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-amber-400' : 'text-blue-300 group-hover:text-white' }} transition-colors"></i>
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
            <span class="text-[10px] font-black uppercase tracking-[0.2em] text-blue-300/60">Infrastructure</span>
        </div>

        @foreach ($proxmoxLocs as $loc)
            <div class="space-y-1">
                <button @click="toggleSection('proxmox_{{ $loc['id'] }}')"
                    class="w-full flex items-center justify-between px-4 py-2.5 rounded-xl text-blue-100 hover:bg-white/10 hover:text-white transition-all group">
                    <div class="flex items-center space-x-3">
                        <i data-lucide="{{ $loc['icon'] }}"
                            class="w-5 h-5 {{ in_array($loc['id'], ['ags', 'punggur']) ? 'text-cyan-400' : (in_array($loc['id'], ['pusat', 'sekupang']) ? 'text-amber-400' : 'text-blue-300') }} group-hover:text-white"></i>
                        <span class="font-semibold text-[13px]">{{ $loc['name'] }}</span>
                    </div>
                    <i data-lucide="chevron-right" class="w-4 h-4 text-blue-300 transition-transform duration-300"
                        :class="openSections.includes('proxmox_{{ $loc['id'] }}') ? 'rotate-90 text-white' : ''"></i>
                </button>

                <div x-show="openSections.includes('proxmox_{{ $loc['id'] }}')" x-collapse
                    class="ml-6 pl-3 border-l-2 border-white/10 space-y-1.5 mt-2 mb-2">

                    <!-- Datacenter Dashboard Link -->
                    <a href="{{ route('proxmox.datacenter', ['location' => $loc['id']]) }}"
                        class="group flex items-center justify-between px-3 py-2.5 rounded-xl transition-all {{ request()->fullUrlIs(route('proxmox.datacenter', ['location' => $loc['id']])) ? 'bg-blue-500/20 text-white font-bold shadow-inner border border-blue-500/30' : 'text-blue-200 hover:bg-white/5 hover:text-white' }}">
                        <div class="flex items-center space-x-3">
                            <div
                                class="w-1.5 h-1.5 rounded-full {{ request()->fullUrlIs(route('proxmox.datacenter', ['location' => $loc['id']])) ? 'bg-amber-400 shadow-[0_0_5px_rgba(251,191,36,0.5)]' : 'bg-blue-400/30 group-hover:bg-blue-300' }} transition-colors">
                            </div>
                            <span class="text-xs tracking-wide">Datacenter Summary</span>
                        </div>
                    </a>

                    <!-- pve Node Item -->
                    <div class="space-y-1">
                        <button @click="toggleSection('proxmox_{{ $loc['id'] }}_pve')"
                            class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-blue-200 hover:text-white hover:bg-white/5 transition-all group text-xs font-medium"
                            :class="openSections.includes('proxmox_{{ $loc['id'] }}_pve') ? 'bg-white/5 text-white' : ''">
                            <div class="flex items-center space-x-3">
                                <div class="w-1.5 h-1.5 rounded-full bg-blue-400/30 group-hover:bg-blue-300 transition-colors"
                                    :class="openSections.includes('proxmox_{{ $loc['id'] }}_pve') ?
                                        'bg-blue-400 shadow-[0_0_5px_rgba(96,165,250,0.5)]' : ''">
                                </div>
                                <span class="font-semibold tracking-wide">Node: pve</span>
                            </div>
                            <i data-lucide="chevron-down" class="w-3.5 h-3.5 transition-transform duration-300"
                                :class="openSections.includes('proxmox_{{ $loc['id'] }}_pve') ? 'rotate-180' : '-rotate-90'"></i>
                        </button>

                        <div x-show="openSections.includes('proxmox_{{ $loc['id'] }}_pve')" x-collapse
                            class="ml-4 pl-3 border-l border-white/10 space-y-1 mt-1">
                            @foreach ($pveItems as $item)
                                <a href="{{ route('proxmox.vm_detail', ['location' => $loc['id'], 'vm_id' => $item['id']]) }}"
                                    class="group flex items-center space-x-3 py-2 px-3 text-[11px] rounded-lg transition-all {{ request()->routeIs('proxmox.vm_detail') && request('vm_id') == $item['id'] && request('location') == $loc['id'] ? 'bg-white/10 text-white font-bold ring-1 ring-white/20' : 'text-blue-300/70 hover:text-white hover:bg-white/5' }}">
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
                                        class="w-3.5 h-3.5 {{ request()->routeIs('proxmox.vm_detail') && request('vm_id') == $item['id'] && request('location') == $loc['id'] ? 'text-amber-400' : 'opacity-50 group-hover:opacity-100 group-hover:text-blue-300' }}"></i>
                                    <span class="tracking-wide">{{ $item['name'] }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="pt-6 pb-2 px-4">
            <span class="text-[10px] font-black uppercase tracking-[0.2em] text-blue-300/60">Credential Password
                VM</span>
        </div>

        @php
            $credColors = [
                '10.13.15.52' => 'text-emerald-400',
                '10.13.15.53' => 'text-violet-400',
                '10.13.15.54' => 'text-amber-400',
            ];
        @endphp
        @foreach (['10.13.15.52', '10.13.15.53', '10.13.15.54'] as $ip)
            <a href="{{ route('credentials.index', ['ip' => $ip]) }}"
                class="group flex items-center space-x-3 px-4 py-2.5 rounded-xl transition-all duration-200 {{ request()->is('credentials/' . $ip) ? 'bg-white/10 text-white shadow-sm ring-1 ring-white/20' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="server"
                    class="w-5 h-5 {{ request()->is('credentials/' . $ip) ? 'text-white' : $credColors[$ip] . ' group-hover:brightness-125' }} transition-colors"></i>
                <span class="font-semibold text-[13px]">Server {{ $ip }}</span>
            </a>
        @endforeach


    </nav>

    <!-- Profile & Session -->
    <div class="p-4 bg-white/5 border-t border-white/10 backdrop-blur-lg mt-auto">
        <div class="flex items-center justify-between px-2">
            <div class="flex items-center space-x-3">
                <div
                    class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center border border-white/10 shadow-inner">
                    <i data-lucide="shield" class="w-5 h-5 text-blue-200"></i>
                </div>
                <div class="flex flex-col">
                    <span
                        class="text-[13px] font-bold text-white truncate max-w-[100px]">{{ session('user_name', 'Admin') }}</span>
                    <span class="text-[10px] text-blue-300 uppercase font-black tracking-wider">Superuser</span>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST" id="logout-form">
                @csrf
                <button type="submit" title="Logout"
                    class="p-2.5 rounded-xl text-blue-300 hover:text-white hover:bg-white/10 shadow-sm transition-all duration-300 group ring-1 ring-white/10 bg-white/5">
                    <i data-lucide="log-out" class="w-4 h-4 group-hover:scale-110 transition-transform"></i>
                </button>
            </form>
        </div>
    </div>
</aside>
