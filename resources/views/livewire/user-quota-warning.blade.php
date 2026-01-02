<div class="glass-card p-4 h-full flex flex-col group/card relative overflow-hidden">
    <div class="flex items-center justify-between mb-4 relative z-10">
        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">QUOTA WARNINGS</h3>
        <div class="w-7 h-7 rounded-lg bg-amber-500/10 flex items-center justify-center border border-amber-500/20">
            <i data-lucide="alert-circle" class="w-3.5 h-3.5 text-amber-500"></i>
        </div>
    </div>

    <div class="space-y-3 relative z-10">
        @forelse ($users as $user)
            @php $percentage = ($user->quota_used_gb / $user->quota_total_gb) * 100; @endphp
            <div class="space-y-2 group/item">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-1.5 h-1.5 rounded-full bg-amber-500 shadow-[0_0_8px_rgba(245,158,11,0.5)]"></div>
                        <span
                            class="text-xs font-black text-white italic tracking-tight uppercase">{{ $user->username }}</span>
                    </div>
                    <span
                        class="text-[10px] font-black text-amber-500 italic">{{ number_format($percentage, 0) }}%</span>
                </div>

                <div class="h-1 bg-slate-950 rounded-full overflow-hidden p-[1px] border border-white/5">
                    <div class="h-full bg-gradient-to-r from-amber-500 to-orange-600 rounded-full transition-all duration-1000 shadow-[0_0_10px_rgba(245,158,11,0.3)]"
                        style="width: {{ $percentage }}%">
                    </div>
                </div>
            </div>
        @empty
            <div class="py-8 flex flex-col items-center justify-center space-y-2 text-slate-500 opacity-40">
                <i data-lucide="check-circle" class="w-10 h-10 opacity-10"></i>
                <p class="text-[9px] font-black uppercase tracking-widest">No limits reached</p>
            </div>
        @endforelse
    </div>
</div>
