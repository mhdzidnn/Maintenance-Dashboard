<div class="glass-card p-4 flex flex-col group/card relative overflow-hidden">
    <div class="flex items-center justify-between mb-3 relative z-10">
        <h3 class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em]">SYSTEM INCIDENTS</h3>
        <span
            class="px-2 py-0.5 bg-red-500/10 text-red-500 text-[8px] font-black rounded-full border border-red-500/20 uppercase tracking-[0.1em]">
            {{ $alerts->count() }} ALERTS
        </span>
    </div>

    <div class="space-y-1.5 relative z-10">
        @foreach ($alerts as $alert)
            @php $isWarning = $alert->type === 'warning'; @endphp
            <div
                class="bg-slate-950/40 rounded-lg p-2 border border-white/5 relative overflow-hidden group/alert hover:bg-slate-900/60 transition-all">
                <div
                    class="absolute left-0 top-0 bottom-0 w-1 {{ $isWarning ? 'bg-amber-500 shadow-[2px_0_10px_rgba(245,158,11,0.3)]' : 'bg-red-600 shadow-[2px_0_10px_rgba(220,38,38,0.3)]' }}">
                </div>

                <div class="flex items-start justify-between pl-1">
                    <div class="flex items-start space-x-2">
                        <div class="mt-0.5">
                            <i data-lucide="{{ $isWarning ? 'alert-triangle' : 'shield-alert' }}"
                                class="w-3.5 h-3.5 {{ $isWarning ? 'text-amber-500' : 'text-red-500' }}"></i>
                        </div>
                        <div>
                            <h4
                                class="font-black {{ $isWarning ? 'text-amber-500' : 'text-red-500' }} uppercase tracking-tight text-[10px] mb-0.5 italic">
                                {{ $alert->title }}
                            </h4>
                            <p class="text-[9px] font-bold text-slate-400 leading-tight italic">{{ $alert->message }}
                            </p>
                        </div>
                    </div>
                    <button wire:click="resolve({{ $alert->id }})"
                        class="w-6 h-6 bg-white/5 hover:bg-emerald-500/20 text-slate-500 hover:text-emerald-400 rounded-lg border border-white/5 hover:border-emerald-500/30 transition-all flex items-center justify-center group/check">
                        <i data-lucide="check" class="w-3 h-3 group-hover/check:scale-110 transition-transform"></i>
                    </button>
                </div>
            </div>
        @endforeach

        @if ($alerts->isEmpty())
            <div class="py-6 flex flex-col items-center justify-center space-y-2 text-slate-500 opacity-40">
                <i data-lucide="shield-check" class="w-6 h-6"></i>
                <p class="text-[9px] font-bold uppercase tracking-[0.2em]">Environment Secured</p>
            </div>
        @endif
    </div>
</div>
