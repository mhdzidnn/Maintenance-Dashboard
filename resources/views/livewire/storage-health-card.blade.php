<div class="glass-card p-4 h-full flex flex-col group/card relative overflow-hidden">
    <div class="absolute top-0 right-0 w-32 h-32 bg-orange-500/5 rounded-full blur-3xl -mr-16 -mt-16"></div>

    <div class="flex items-center justify-between mb-4 relative z-10">
        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">STORAGE HEALTH</h3>
        <div class="w-7 h-7 rounded-lg bg-orange-500/10 flex items-center justify-center border border-orange-500/20">
            <i data-lucide="hard-drive" class="w-3.5 h-3.5 text-orange-400"></i>
        </div>
    </div>

    @isset($storage)
        <div class="space-y-4 relative z-10 flex-1 flex flex-col justify-center">
            <div class="flex items-end justify-between mb-1">
                <div>
                    <span
                        class="text-5xl font-black text-white tracking-tighter">{{ number_format($storage->usage_percentage, 0) }}<span
                            class="text-xl text-orange-500 ml-0.5">%</span></span>
                    <p class="text-[9px] font-bold text-slate-500 uppercase tracking-widest mt-0.5">CAPACITY USED</p>
                </div>
                <div class="text-right">
                    <span
                        class="text-[10px] font-black text-white uppercase tracking-tighter">{{ $storage->raid_status }}</span>
                    <p class="text-[9px] font-bold text-slate-500 uppercase tracking-widest mt-0.5">RAID STATUS</p>
                </div>
            </div>

            <div class="relative group/progress">
                <div class="h-3 bg-slate-950/50 rounded-full overflow-hidden border border-white/5 p-[1px]">
                    <div class="h-full rounded-full transition-all duration-1000 ease-out relative overflow-hidden shadow-[0_0_15px_rgba(249,115,22,0.3)]"
                        style="width: {{ $storage->usage_percentage }}%; background: linear-gradient(90deg, #f97316, #ef4444); background-size: 30px 30px; background-image: linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent); animation: stripes 2s linear infinite;">
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-2 mt-auto pt-4 border-t border-white/5">
                <div class="flex items-center space-x-2">
                    <div class="w-1.5 h-1.5 rounded-full bg-blue-500 shadow-[0_0_8px_rgba(59,130,246,0.5)]"></div>
                    <span class="text-[10px] font-bold text-slate-300">Local: <span
                            class="text-white">{{ number_format($storage->local_percentage, 0) }}%</span></span>
                </div>
                <div class="flex items-center justify-end space-x-1">
                    <i data-lucide="trending-up" class="w-2.5 h-2.5 text-emerald-400"></i>
                    <span
                        class="text-[9px] font-black text-emerald-400 uppercase tracking-widest">{{ $storage->trend }}</span>
                </div>
            </div>
        </div>
        <style>
            @keyframes stripes {
                from {
                    background-position: 0 0;
                }

                to {
                    background-position: 60px 0;
                }
            }
        </style>
    @else
        <div class="flex flex-col items-center justify-center flex-1 py-6 text-slate-500 italic relative z-10">
            <i data-lucide="info" class="w-10 h-10 mb-2 opacity-10"></i>
            <p class="text-[10px] font-bold uppercase tracking-widest opacity-40">No records</p>
        </div>
    @endisset
</div>
