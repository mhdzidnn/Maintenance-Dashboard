<aside x-data="{
    openSection: localStorage.getItem('sidebar_section') || null,
    toggleSection(section) {
        this.openSection = this.openSection === section ? null : section;
        localStorage.setItem('sidebar_section', this.openSection);
    }
}"
    class="w-64 bg-slate-900 border-r border-slate-800 flex flex-col h-full transition-all duration-300">
    <!-- Logo Section -->
    <div class="p-6 flex items-center space-x-4 border-b border-white/5">
        <div
            class="w-12 h-12 rounded-2xl bg-white p-1.5 flex items-center justify-center shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-white/10 group-hover:scale-105 transition-transform duration-500">
            <img src="{{ asset('img/persero batam.jpeg') }}" class="w-full h-full object-contain"
                alt="IT Persero Batam Logo">
        </div>
        <div class="flex flex-col justify-center">
            <span class="text-lg font-black tracking-tighter text-white uppercase leading-none">IT PERSERO</span>
            <div class="flex items-center space-x-1.5">
                <span class="text-lg font-black tracking-tighter text-white uppercase leading-none">BATAM</span>
                <div class="w-1.5 h-1.5 rounded-full bg-blue-600 animate-pulse"></div>
            </div>
        </div>
    </div>

    <!-- Navigation Section -->
    <nav class="flex-1 px-4 space-y-1 mt-4 overflow-y-auto scrollbar-hide">
        <!-- Dashboard Link -->
        <a href="{{ route('dashboard') }}"
            class="flex items-center space-x-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('dashboard') ? 'bg-blue-600/10 text-blue-400' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
            <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
            <span class="font-medium">Dashboard</span>
        </a>

        <!-- Proxmox Section -->
        <div class="space-y-1">
            <button @click="toggleSection('proxmox')"
                class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800 hover:text-white transition-all group">
                <div class="flex items-center space-x-3">
                    <i data-lucide="server" class="w-5 h-5 group-hover:text-blue-400"></i>
                    <span class="font-medium">Proxmox</span>
                </div>
                <i data-lucide="chevron-right" class="w-4 h-4 transition-transform duration-200"
                    :class="openSection === 'proxmox' ? 'rotate-90' : ''"></i>
            </button>
            <div x-show="openSection === 'proxmox'" x-collapse class="pl-11 space-y-1">
                <a href="{{ route('proxmox.nodes') }}"
                    class="block py-1.5 text-sm {{ request()->routeIs('proxmox.nodes') ? 'text-blue-400 font-bold' : 'text-slate-500 hover:text-blue-400' }}">Node</a>
                <a href="{{ route('proxmox.storage') }}"
                    class="block py-1.5 text-sm {{ request()->routeIs('proxmox.storage') ? 'text-blue-400 font-bold' : 'text-slate-500 hover:text-blue-400' }}">Storage</a>
                <a href="{{ route('proxmox.vms') }}"
                    class="block py-1.5 text-sm {{ request()->routeIs('proxmox.vms') ? 'text-blue-400 font-bold' : 'text-slate-500 hover:text-blue-400' }}">VMs</a>
                <a href="{{ route('proxmox.memory') }}"
                    class="block py-1.5 text-sm {{ request()->routeIs('proxmox.memory') ? 'text-blue-400 font-bold' : 'text-slate-500 hover:text-blue-400' }}">Memory</a>
            </div>
        </div>

        <!-- Nextcloud Section -->
        <div class="space-y-1">
            <button @click="toggleSection('nextcloud')"
                class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800 hover:text-white transition-all group">
                <div class="flex items-center space-x-3">
                    <i data-lucide="cloud" class="w-5 h-5 group-hover:text-emerald-400"></i>
                    <span class="font-medium">Nextcloud</span>
                </div>
                <i data-lucide="chevron-right" class="w-4 h-4 transition-transform duration-200"
                    :class="openSection === 'nextcloud' ? 'rotate-90' : ''"></i>
            </button>
            <div x-show="openSection === 'nextcloud'" x-collapse class="pl-11 space-y-1">
                <a href="{{ route('nextcloud.overview') }}"
                    class="block py-1.5 text-sm {{ request()->routeIs('nextcloud.overview') ? 'text-emerald-400 font-bold' : 'text-slate-500 hover:text-emerald-400' }}">Overview</a>
                <a href="{{ route('nextcloud.users') }}"
                    class="block py-1.5 text-sm {{ request()->routeIs('nextcloud.users') ? 'text-emerald-400 font-bold' : 'text-slate-500 hover:text-emerald-400' }}">Users</a>
                <a href="{{ route('nextcloud.storage') }}"
                    class="block py-1.5 text-sm {{ request()->routeIs('nextcloud.storage') ? 'text-emerald-400 font-bold' : 'text-slate-500 hover:text-emerald-400' }}">Storage</a>
            </div>
        </div>

        <!-- System Section -->
        <div class="space-y-1">
            <button @click="toggleSection('system')"
                class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800 hover:text-white transition-all group">
                <div class="flex items-center space-x-3">
                    <i data-lucide="settings" class="w-5 h-5 group-hover:text-amber-400"></i>
                    <span class="font-medium">System</span>
                </div>
                <i data-lucide="chevron-right" class="w-4 h-4 transition-transform duration-200"
                    :class="openSection === 'system' ? 'rotate-90' : ''"></i>
            </button>
            <div x-show="openSection === 'system'" x-collapse class="pl-11 space-y-1">
                <a href="{{ route('system.alerts') }}"
                    class="block py-1.5 text-sm {{ request()->routeIs('system.alerts') ? 'text-amber-400 font-bold' : 'text-slate-500 hover:text-amber-400' }}">Alerts</a>
                <a href="{{ route('system.logs') }}"
                    class="block py-1.5 text-sm {{ request()->routeIs('system.logs') ? 'text-amber-400 font-bold' : 'text-slate-500 hover:text-amber-400' }}">Logs</a>
            </div>
        </div>
    </nav>

    <!-- Bottom Action -->
    <div class="p-4 border-t border-slate-800 mt-auto">
        <div class="flex items-center justify-between px-2">
            <div class="flex items-center space-x-3">
                <div
                    class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center border border-slate-700">
                    <i data-lucide="user" class="w-5 h-5 text-slate-400"></i>
                </div>
                <div>
                    <div class="text-sm font-semibold text-white">Admin</div>
                    <div class="text-xs text-slate-500">Logout</div>
                </div>
            </div>
            <button class="text-slate-500 hover:text-red-400 transition-colors">
                <i data-lucide="log-out" class="w-5 h-5"></i>
            </button>
        </div>
    </div>
</aside>
