<header
    class="h-16 flex items-center justify-between px-8 bg-slate-900 border-b border-slate-800 z-10 w-full sticky top-0">
    <!-- Left Section (Logo/Title) -->
    <div class="flex items-center space-x-3">
        <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/20">
            <i data-lucide="shield" class="w-4 h-4 text-white"></i>
        </div>
        <h2 class="text-lg font-bold text-white tracking-tight">Maintenance Dashboard</h2>
    </div>

    <!-- Right Section (Actions/User) -->
    <div class="flex items-center space-x-6">
        <!-- Icons -->
        <div class="flex items-center space-x-4">
            <button class="text-slate-500 hover:text-white transition-colors relative">
                <i data-lucide="mail" class="w-5 h-5"></i>
            </button>
            <button class="text-slate-500 hover:text-white transition-colors relative group">
                <i data-lucide="bell" class="w-5 h-5"></i>
                <span
                    class="absolute -top-0.5 -right-0.5 w-2 h-2 rounded-full bg-red-500 ring-2 ring-slate-900 animate-pulse"></span>
            </button>
        </div>

        <!-- Divider -->
        <div class="h-6 w-px bg-slate-800"></div>

        <!-- User Info -->
        <div class="flex items-center space-x-2 text-sm font-bold">
            <span class="text-slate-400">Admin</span>
            <span class="text-slate-600">|</span>
            <button class="text-slate-400 hover:text-red-400 transition-colors">Logout</button>
        </div>
    </div>
</header>
