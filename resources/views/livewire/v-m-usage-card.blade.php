<div class="glass-card p-4 h-full flex flex-col group/card relative overflow-hidden">
    <div class="flex items-center justify-between mb-4 relative z-10">
        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">TOP VM USAGE</h3>
        <span
            class="text-[9px] font-black text-slate-500 bg-slate-950/30 px-2 py-0.5 rounded-full border border-white/5 uppercase tracking-widest italic">
            {{ $vms->where('is_running', true)->count() }} active
        </span>
    </div>

    <div class="space-y-2 relative z-10">
        @forelse ($vms as $vm)
            <div
                class="flex items-center justify-between p-3 bg-slate-950/30 rounded-xl border border-white/5 hover:border-blue-500/30 hover:bg-slate-900/40 transition-all group/item">
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <div
                            class="w-8 h-8 bg-slate-900 rounded-lg flex items-center justify-center border border-white/5">
                            <i data-lucide="cpu"
                                class="w-4 h-4 text-slate-500 group-hover/item:text-blue-400 transition-colors"></i>
                        </div>
                        <div
                            class="absolute -top-1 -right-1 w-2.5 h-2.5 rounded-full border-2 border-slate-950 {{ $vm->is_running ? 'bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]' : 'bg-slate-600' }}">
                        </div>
                    </div>
                    <div>
                        <p class="text-[8px] font-black text-slate-500 uppercase tracking-widest mb-0 italic">
                            {{ $vm->vm_id }}</p>
                        <h4 class="text-xs font-black text-white italic tracking-tight uppercase">{{ $vm->name }}
                        </h4>
                    </div>
                </div>
                <div class="text-right flex flex-col items-end">
                    <span class="text-base font-black text-white italic tracking-tighter">{{ $vm->usage_gb }}<span
                            class="text-[10px] text-blue-500 ml-0.5">GB</span></span>
                </div>
            </div>
        @empty
            <div
                class="py-8 text-center text-slate-500 italic font-bold text-[10px] uppercase tracking-widest opacity-40">
                No records</div>
        @endforelse
    </div>
</div>
