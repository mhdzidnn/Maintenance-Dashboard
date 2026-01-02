<div class="glass-card p-4 flex flex-col group/card relative overflow-hidden">
    <div class="flex items-center justify-between mb-4 relative z-10">
        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">QUICK ACTIONS</h3>
        <span class="text-[8px] font-black text-slate-500 uppercase tracking-widest italic">Rapid</span>
    </div>

    <div class="grid grid-cols-2 gap-3 relative z-10">
        @php
            $actions = [
                ['name' => 'FS Trim', 'icon' => 'wrench', 'color' => 'blue'],
                ['name' => 'Clear Cache', 'icon' => 'trash-2', 'color' => 'emerald'],
                ['name' => 'Disk Scan', 'icon' => 'file-check', 'color' => 'amber'],
                ['name' => 'Snapshots', 'icon' => 'camera', 'color' => 'purple'],
            ];
        @endphp

        @foreach ($actions as $action)
            <button wire:click="runAction('{{ $action['name'] }}')"
                class="flex flex-col items-center justify-center p-3 bg-slate-950/30 hover:bg-{{ $action['color'] }}-500/10 border border-white/5 hover:border-{{ $action['color'] }}-500/30 rounded-xl transition-all group/btn disabled:opacity-50"
                {{ $isProcessing ? 'disabled' : '' }}>
                <div
                    class="w-10 h-10 rounded-xl bg-slate-900 flex items-center justify-center mb-2 border border-white/5 group-hover/btn:scale-105 transition-transform">
                    <i data-lucide="{{ $action['icon'] }}"
                        class="w-4 h-4 text-slate-500 group-hover/btn:text-{{ $action['color'] }}-400 transition-colors {{ $activeAction === $action['name'] ? 'animate-spin' : '' }}"></i>
                </div>
                <span
                    class="text-[9px] font-black text-white uppercase tracking-widest text-center">{{ $action['name'] }}</span>
            </button>
        @endforeach
    </div>

    @if ($isProcessing)
        <div
            class="mt-4 flex items-center justify-center space-x-2 text-[9px] font-black text-blue-400 uppercase tracking-[0.2em] animate-pulse italic relative z-10 bg-blue-500/5 py-2 rounded-xl border border-blue-500/10">
            <i data-lucide="activity" class="w-3 h-3 animate-bounce"></i>
            <span>{{ $activeAction }}</span>
        </div>
    @endif
</div>
