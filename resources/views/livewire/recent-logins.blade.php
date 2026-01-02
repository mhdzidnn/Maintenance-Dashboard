<div class="glass-card p-4 flex flex-col group/card relative overflow-hidden">
    <div class="flex items-center justify-between mb-4 relative z-10">
        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">ACCESS LOGS</h3>
        <div class="w-7 h-7 rounded-lg bg-blue-500/10 flex items-center justify-center border border-blue-500/20">
            <i data-lucide="history" class="w-3.5 h-3.5 text-blue-400"></i>
        </div>
    </div>

    <div class="space-y-2 relative z-10">
        @foreach ($users as $user)
            <div
                class="flex items-center justify-between group/item p-2 rounded-xl border border-transparent hover:border-white/5 hover:bg-white/5 transition-all">
                <div class="flex items-center space-x-2">
                    <div
                        class="w-8 h-8 rounded-lg bg-blue-600/10 flex items-center justify-center border border-blue-500/20 group-hover/item:bg-blue-600/20 transition-all">
                        <span
                            class="text-[10px] font-black text-blue-400 uppercase">{{ substr($user->username, 0, 1) }}</span>
                    </div>
                    <div>
                        <h4 class="text-xs font-black text-white italic tracking-tight uppercase">{{ $user->username }}
                        </h4>
                        <p class="text-[8px] font-bold text-slate-500 uppercase tracking-widest">
                            {{ $user->last_login->diffForHumans() }}</p>
                    </div>
                </div>
                <div class="flex space-x-[1.5px]">
                    @for ($i = 0; $i < 4; $i++)
                        <div
                            class="w-1 h-2 rounded-full {{ $i < 4 - $loop->index ? 'bg-blue-500/60 shadow-[0_0_5px_rgba(59,130,246,0.3)]' : 'bg-slate-800' }}">
                        </div>
                    @endfor
                </div>
            </div>
        @endforeach
    </div>

    <button
        class="mt-auto pt-4 w-full text-[9px] font-black text-slate-500 hover:text-blue-400 uppercase tracking-[0.1em] transition-all relative z-10 flex items-center justify-center group/btn">
        <span>Audit Trail</span>
        <i data-lucide="external-link"
            class="w-2.5 h-2.5 ml-1.5 group-hover/btn:translate-x-1 group-hover/btn:-translate-y-1 transition-transform"></i>
    </button>
</div>
