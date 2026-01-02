<div class="glass-card p-4 flex flex-col group/card relative overflow-hidden">
    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/5 rounded-full blur-3xl -mr-16 -mt-16"></div>

    <div class="flex items-center justify-between mb-4 relative z-10">
        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">NEXT CLOUD OVERVIEW</h3>
        <div class="w-7 h-7 rounded-lg bg-blue-500/10 flex items-center justify-center border border-blue-500/20">
            <i data-lucide="cloud" class="w-3.5 h-3.5 text-blue-400"></i>
        </div>
    </div>

    @isset($stats)
        <div class="space-y-4 relative z-10 flex flex-col">
            <div class="grid grid-cols-2 gap-3">
                <div class="p-3 rounded-xl bg-slate-950/30 border border-white/5">
                    <p class="text-[8px] font-black text-slate-500 uppercase tracking-widest mb-0.5">Status</p>
                    <div class="flex items-center">
                        <span
                            class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5 shadow-[0_0_8px_rgba(16,185,129,0.5)]"></span>
                        <span class="text-xs font-black text-white italic tracking-tight uppercase">Online</span>
                    </div>
                </div>
                <div class="p-3 rounded-xl bg-slate-950/30 border border-white/5">
                    <p class="text-[8px] font-black text-slate-500 uppercase tracking-widest mb-0.5">Users</p>
                    <span class="text-base font-black text-white italic tracking-tight">{{ $stats->total_users }}</span>
                </div>
            </div>

            <div class="space-y-2">
                <div class="flex justify-between items-end">
                    <div>
                        <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">Storage</p>
                        <span
                            class="text-xl font-black text-white tracking-tighter">{{ number_format($stats->storage_used_tb, 1) }}<span
                                class="text-blue-500 text-xs ml-0.5">TB</span></span>
                    </div>
                    @php $percentage = ($stats->storage_used_tb / $stats->storage_total_tb) * 100; @endphp
                    <span class="text-xs font-black text-blue-400 italic">{{ number_format($percentage, 0) }}%</span>
                </div>
                <div class="h-1.5 bg-slate-950 rounded-full overflow-hidden p-[1px] border border-white/5">
                    <div class="h-full bg-gradient-to-r from-blue-600 to-cyan-500 rounded-full shadow-[0_0_10px_rgba(59,130,246,0.3)]"
                        style="width: {{ $percentage }}%">
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="flex flex-col items-center justify-center flex-1 py-6 text-slate-500 italic relative z-10">
            <i data-lucide="cloud-off" class="w-10 h-10 mb-2 opacity-10"></i>
            <p class="text-[10px] font-bold uppercase tracking-widest opacity-40">Not Connected</p>
        </div>
    @endisset
</div>
