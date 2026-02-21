@extends('layouts.app')

@section('content')
    @php
        $now = \Carbon\Carbon::now();
        $totalVms = array_sum(array_column($sites, 'total'));
        $onlineCount = count(array_filter($sites, fn($s) => $s['status'] === 'online'));
        $warningCount = count(array_filter($sites, fn($s) => $s['status'] === 'warning'));
        $totalRunning = array_sum(array_column($sites, 'running'));
        $avgCpu = count($sites) > 0 ? round(array_sum(array_column($sites, 'cpu')) / count($sites)) : 0;
        $avgMem = count($sites) > 0 ? round(array_sum(array_column($sites, 'mem')) / count($sites)) : 0;
    @endphp

    <div class="space-y-6">

        {{-- ── Page Header ── --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Overview Dashboard</h1>
                <p class="text-slate-500 text-sm mt-0.5">
                    IT Persero Batam &mdash; Infrastructure Monitoring
                    <span class="ml-2 text-slate-400 font-mono text-xs">{{ $now->format('d M Y, H:i') }}</span>
                </p>
            </div>
            <span
                class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-bold">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                Live Monitoring
            </span>
        </div>

        {{-- ── Summary Cards ── --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            @php
                $summaries = [
                    [
                        'label' => 'Total Proxmox Sites',
                        'value' => count($sites),
                        'icon' => 'server',
                        'color' => 'blue',
                        'sub' => count($sites) . ' infrastructure nodes',
                    ],
                    [
                        'label' => 'Total VMs / LXC',
                        'value' => $totalVms,
                        'icon' => 'cpu',
                        'color' => 'violet',
                        'sub' => $totalRunning . ' running saat ini',
                    ],
                    [
                        'label' => 'Sites Online',
                        'value' => $onlineCount,
                        'icon' => 'shield-check',
                        'color' => 'emerald',
                        'sub' => $warningCount . ' site(s) need attention',
                    ],
                    [
                        'label' => 'Avg CPU Usage',
                        'value' => $avgCpu . '%',
                        'icon' => 'activity',
                        'color' => 'amber',
                        'sub' => 'Avg Memory ' . $avgMem . '%',
                    ],
                ];
                $colorMap = [
                    'blue' => ['bg' => 'bg-blue-50', 'icon' => 'text-blue-600', 'ring' => 'ring-blue-200'],
                    'violet' => ['bg' => 'bg-violet-50', 'icon' => 'text-violet-600', 'ring' => 'ring-violet-200'],
                    'emerald' => ['bg' => 'bg-emerald-50', 'icon' => 'text-emerald-600', 'ring' => 'ring-emerald-200'],
                    'amber' => ['bg' => 'bg-amber-50', 'icon' => 'text-amber-600', 'ring' => 'ring-amber-200'],
                ];
            @endphp
            @foreach ($summaries as $s)
                @php $c = $colorMap[$s['color']]; @endphp
                <div
                    class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm flex items-start gap-4 hover:shadow-md transition-shadow">
                    <div
                        class="w-11 h-11 rounded-xl {{ $c['bg'] }} {{ $c['ring'] }} ring-1 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="{{ $s['icon'] }}" class="w-5 h-5 {{ $c['icon'] }}"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs text-slate-500 font-semibold uppercase tracking-wide leading-none mb-1">
                            {{ $s['label'] }}</p>
                        <p class="text-2xl font-black text-slate-800 leading-none mb-1">{{ $s['value'] }}</p>
                        <p class="text-[11px] text-slate-400">{{ $s['sub'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- ── Proxmox Site Cards (real data) ── --}}
        <div>
            <h2 class="text-sm font-bold text-slate-600 uppercase tracking-widest mb-3 flex items-center gap-2">
                <i data-lucide="layers" class="w-4 h-4"></i> Proxmox Infrastructure Status
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
                @foreach ($sites as $site)
                    @php
                        $isWarning = $site['status'] === 'warning';
                        $cpuBarColor =
                            $site['cpu'] >= 75 ? 'bg-red-500' : ($site['cpu'] >= 50 ? 'bg-amber-400' : 'bg-blue-500');
                        $memBarColor =
                            $site['mem'] >= 75
                                ? 'bg-red-500'
                                : ($site['mem'] >= 50
                                    ? 'bg-amber-400'
                                    : 'bg-emerald-500');
                    @endphp
                    <div
                        class="bg-white rounded-2xl border {{ $isWarning ? 'border-amber-300' : 'border-slate-200' }} p-5 shadow-sm hover:shadow-md transition-all">
                        {{-- Header --}}
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-2">
                                <div
                                    class="w-8 h-8 rounded-lg {{ $isWarning ? 'bg-amber-50' : 'bg-blue-50' }} flex items-center justify-center">
                                    <i data-lucide="activity"
                                        class="w-4 h-4 {{ $isWarning ? 'text-amber-500' : 'text-cyan-500' }}"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500 font-semibold leading-none">Proxmox</p>
                                    <p class="text-sm font-bold text-slate-800">{{ $site['name'] }}</p>
                                </div>
                            </div>
                            <span
                                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase
                        {{ $isWarning ? 'bg-amber-100 text-amber-700' : 'bg-emerald-100 text-emerald-700' }}">
                                <span
                                    class="w-1.5 h-1.5 rounded-full {{ $isWarning ? 'bg-amber-500' : 'bg-emerald-500 animate-pulse' }}"></span>
                                {{ $isWarning ? 'Warning' : 'Online' }}
                            </span>
                        </div>

                        {{-- VM counts --}}
                        <div class="flex items-center justify-around text-center mb-4">
                            <div>
                                <p class="text-lg font-black text-slate-800">{{ $site['total'] }}</p>
                                <p class="text-[10px] text-slate-400 font-semibold uppercase">Total VM/LXC</p>
                            </div>
                            <div class="w-px h-8 bg-slate-100"></div>
                            <div>
                                <p class="text-lg font-black text-emerald-600">{{ $site['running'] }}</p>
                                <p class="text-[10px] text-slate-400 font-semibold uppercase">Running</p>
                            </div>
                            <div class="w-px h-8 bg-slate-100"></div>
                            <div>
                                <p class="text-lg font-black text-slate-400">{{ $site['stopped'] }}</p>
                                <p class="text-[10px] text-slate-400 font-semibold uppercase">Stopped</p>
                            </div>
                        </div>

                        {{-- Uptime representative --}}
                        <p class="text-[11px] text-slate-400 flex items-center gap-1 mb-3">
                            <i data-lucide="clock" class="w-3 h-3"></i>
                            Uptime: <span class="font-semibold text-slate-600 ml-1">{{ $site['uptime'] }}</span>
                        </p>

                        {{-- CPU bar --}}
                        <div class="space-y-1 mb-2">
                            <div class="flex justify-between text-[11px] font-semibold text-slate-500">
                                <span>Avg CPU (running VMs)</span><span>{{ $site['cpu'] }}%</span>
                            </div>
                            <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                <div class="{{ $cpuBarColor }} h-full rounded-full" style="width:{{ $site['cpu'] }}%">
                                </div>
                            </div>
                        </div>

                        {{-- Memory bar --}}
                        <div class="space-y-1 mb-4">
                            <div class="flex justify-between text-[11px] font-semibold text-slate-500">
                                <span>Avg Memory (running VMs)</span><span>{{ $site['mem'] }}%</span>
                            </div>
                            <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                <div class="{{ $memBarColor }} h-full rounded-full" style="width:{{ $site['mem'] }}%">
                                </div>
                            </div>
                        </div>

                        {{-- Link --}}
                        <a href="{{ route('proxmox.datacenter', ['location' => $site['location']]) }}"
                            class="flex items-center justify-between text-[11px] font-bold text-slate-400 hover:text-blue-600 transition-colors group/link">
                            <span>Lihat Datacenter</span>
                            <i data-lucide="arrow-right"
                                class="w-3.5 h-3.5 group-hover/link:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- ── Bottom Row: Credential Servers + Recent Activity (dummy) ── --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 pb-6">

            {{-- Credential Server Quick Access --}}
            <div class="lg:col-span-1 bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                <h3 class="text-xs font-black text-slate-500 uppercase tracking-widest mb-4 flex items-center gap-2">
                    <i data-lucide="server" class="w-4 h-4 text-slate-400"></i> Credential Password VM
                </h3>
                <div class="space-y-2">
                    @foreach ([['ip' => '10.13.15.52', 'color' => 'text-emerald-500', 'bg' => 'bg-emerald-50'], ['ip' => '10.13.15.53', 'color' => 'text-violet-500', 'bg' => 'bg-violet-50'], ['ip' => '10.13.15.54', 'color' => 'text-amber-500', 'bg' => 'bg-amber-50']] as $srv)
                        <a href="{{ route('credentials.index', ['ip' => $srv['ip']]) }}"
                            class="flex items-center justify-between px-4 py-3 rounded-xl border border-slate-100 hover:border-blue-200 hover:bg-blue-50/50 transition-all group">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg {{ $srv['bg'] }} flex items-center justify-center">
                                    <i data-lucide="server" class="w-4 h-4 {{ $srv['color'] }}"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-700 font-mono">{{ $srv['ip'] }}</p>
                                    <p class="text-[10px] text-slate-400">VM Credential Server</p>
                                </div>
                            </div>
                            <i data-lucide="arrow-right"
                                class="w-4 h-4 text-slate-300 group-hover:text-blue-500 group-hover:translate-x-1 transition-all"></i>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Recent Activity Log (dummy) --}}
            <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                <h3 class="text-xs font-black text-slate-500 uppercase tracking-widest mb-4 flex items-center gap-2">
                    <i data-lucide="clock" class="w-4 h-4 text-slate-400"></i> Aktivitas Terkini
                </h3>
                @php
                    $activities = [
                        [
                            'time' => '14:30',
                            'label' => 'VM 100 (win10-multifunction) started successfully',
                            'site' => 'AGS',
                            'icon' => 'play-circle',
                            'color' => 'text-emerald-500',
                        ],
                        [
                            'time' => '13:55',
                            'label' => 'CPU usage VM 103 (ubuntu-24) mencapai 95%',
                            'site' => 'Kantor Pusat',
                            'icon' => 'alert-triangle',
                            'color' => 'text-red-500',
                        ],
                        [
                            'time' => '12:10',
                            'label' => 'Credential Server 10.13.15.53 diperbarui',
                            'site' => 'System',
                            'icon' => 'edit',
                            'color' => 'text-blue-500',
                        ],
                        [
                            'time' => '11:45',
                            'label' => 'VM 101 (win10in02) memory usage 90%',
                            'site' => 'Kantor Pusat',
                            'icon' => 'alert-triangle',
                            'color' => 'text-amber-500',
                        ],
                        [
                            'time' => '09:20',
                            'label' => 'LXC 6690 (VPN site-to-site) running normal',
                            'site' => 'AGS',
                            'icon' => 'shield-check',
                            'color' => 'text-emerald-500',
                        ],
                        [
                            'time' => '08:00',
                            'label' => 'VM 102 (win10in01) stopped di Proxmox Sekupang',
                            'site' => 'Sekupang',
                            'icon' => 'stop-circle',
                            'color' => 'text-slate-400',
                        ],
                    ];
                @endphp
                <div class="space-y-0 divide-y divide-slate-50">
                    @foreach ($activities as $act)
                        <div class="flex items-start gap-3 py-3">
                            <i data-lucide="{{ $act['icon'] }}"
                                class="w-4 h-4 mt-0.5 flex-shrink-0 {{ $act['color'] }}"></i>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-slate-700 leading-snug">{{ $act['label'] }}</p>
                                <p class="text-[10px] text-slate-400 mt-0.5">{{ $act['site'] }}</p>
                            </div>
                            <span class="text-[11px] font-mono text-slate-400 flex-shrink-0">{{ $act['time'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
    </script>
@endsection
