<div class="glass-card p-4 h-full flex flex-col group/card relative overflow-hidden">
    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/5 rounded-full blur-3xl -mr-16 -mt-16"></div>

    <div class="flex items-center justify-between mb-4 relative z-10">
        <div class="flex items-center space-x-4">
            <div
                class="w-10 h-10 bg-blue-600/10 rounded-2xl flex items-center justify-center border border-blue-500/20 group-hover/card:scale-110 transition-transform">
                <i data-lucide="server" class="w-5 h-5 text-blue-400"></i>
            </div>
            <div>
                <h3 class="text-lg font-black text-white italic tracking-tight">{{ $node->name ?? 'Unknown' }}</h3>
                <p class="text-[9px] font-bold text-slate-500 uppercase tracking-widest">Main Infrastructure Node</p>
            </div>
        </div>

        <div class="relative">
            @if ($node)
                @php
                    $statusColor = match ($node->status) {
                        'healthy' => 'emerald',
                        'warning' => 'amber',
                        default => 'red',
                    };
                @endphp
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-[9px] font-black bg-{{ $statusColor }}-500/10 text-{{ $statusColor }}-400 border border-{{ $statusColor }}-500/20 uppercase tracking-widest shadow-[0_0_15px_rgba(var(--color-{{ $statusColor }}-500),0.2)]">
                    <span class="w-1.5 h-1.5 rounded-full bg-{{ $statusColor }}-500 mr-2 animate-pulse"></span>
                    {{ $node->status }}
                </span>
            @else
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-[9px] font-black bg-slate-500/10 text-slate-400 border border-slate-500/20 uppercase tracking-widest">
                    Offline
                </span>
            @endif
        </div>
    </div>

    @if ($node)
        <div class="grid grid-cols-2 gap-4 relative z-10 py-4 border-y border-white/5">
            <div class="space-y-1">
                <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">System Uptime</p>
                <div class="flex items-baseline space-x-1">
                    <span class="text-2xl font-black text-white tracking-tighter">{{ $node->uptime_days }}</span>
                    <span class="text-[10px] font-bold text-slate-400 italic">days</span>
                </div>
            </div>
            <div class="space-y-1">
                <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Reliability Score</p>
                <div class="flex items-baseline space-x-1">
                    <span
                        class="text-2xl font-black text-white tracking-tighter">{{ number_format($node->uptime_percentage, 1) }}</span>
                    <span class="text-[10px] font-bold text-slate-400 italic">%</span>
                </div>
            </div>
        </div>
    @else
        <div class="py-6 text-center relative z-10 border-y border-white/5">
            <p class="text-slate-500 italic text-[10px] font-bold uppercase tracking-widest opacity-40">Node Data
                Unavailable</p>
        </div>
    @endif

    <div class="mt-auto pt-4 flex items-center justify-between relative z-10">
        <div class="flex items-center space-x-2 text-[9px] font-bold text-slate-500 uppercase tracking-widest">
            <i data-lucide="refresh-cw" class="w-2.5 h-2.5 animate-spin"></i>
            <span>Real-time sync</span>
        </div>
        <a href="#"
            class="group/btn flex items-center space-x-2 bg-white/5 hover:bg-blue-600 transition-all px-3 py-1.5 rounded-xl border border-white/5 hover:border-blue-500">
            <span class="text-[9px] font-black text-white uppercase tracking-widest">Analytics</span>
            <i data-lucide="arrow-right"
                class="w-2.5 h-2.5 text-white group-hover/btn:translate-x-1 transition-transform"></i>
        </a>
    </div>
</div>
