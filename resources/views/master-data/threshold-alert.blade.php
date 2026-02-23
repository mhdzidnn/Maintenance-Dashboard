@extends('layouts.app')

@section('content')
    <div x-data="thresholdManager()" class="space-y-6">

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Threshold Alert</h1>
                <p class="text-slate-500 text-sm mt-0.5">Konfigurasi batas ambang peringatan CPU, Memory, dan Disk per lokasi
                </p>
            </div>
            <span
                class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-bold bg-amber-50 border border-amber-200 text-amber-700 rounded-full">
                <i data-lucide="alert-triangle" class="w-3.5 h-3.5"></i> Alert Configuration
            </span>
        </div>

        {{-- Info bar --}}
        <div class="bg-blue-50 border border-blue-200 rounded-xl px-5 py-3 flex items-start gap-3">
            <i data-lucide="info" class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5"></i>
            <p class="text-sm text-blue-700">Jika penggunaan CPU, Memory, atau Disk VM melebihi threshold yang diset, maka
                status site akan berubah menjadi <strong>Warning</strong> di dashboard dan monitoring.</p>
        </div>

        {{-- Threshold Cards per Site --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <template x-for="site in data" :key="site.id">
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    {{-- Card Header --}}
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center">
                                <i data-lucide="activity" class="w-4 h-4 text-cyan-500"></i>
                            </div>
                            <div>
                                <p class="font-bold text-slate-800 text-sm" x-text="'Proxmox ' + site.nama"></p>
                                <p class="text-[11px] text-slate-400 font-mono" x-text="site.key"></p>
                            </div>
                        </div>
                        <button @click="editThreshold(site)"
                            class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                            <i data-lucide="settings" class="w-3.5 h-3.5"></i> Ubah
                        </button>
                    </div>

                    {{-- Threshold Values --}}
                    <div class="p-6 space-y-4">
                        {{-- CPU --}}
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <span
                                    class="text-xs font-bold text-slate-500 uppercase tracking-wide flex items-center gap-1.5">
                                    <i data-lucide="cpu" class="w-3.5 h-3.5 text-blue-400"></i> CPU Threshold
                                </span>
                                <span class="text-sm font-black" :class="site.cpu >= 80 ? 'text-red-600' : 'text-slate-800'"
                                    x-text="site.cpu + '%'"></span>
                            </div>
                            <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full rounded-full transition-all"
                                    :class="site.cpu >= 80 ? 'bg-red-400' : 'bg-blue-400'"
                                    :style="'width:' + site.cpu + '%'"></div>
                            </div>
                            <p class="text-[10px] text-slate-400">Alert jika CPU melebihi <span class="font-semibold"
                                    x-text="site.cpu + '%'"></span></p>
                        </div>

                        {{-- Memory --}}
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <span
                                    class="text-xs font-bold text-slate-500 uppercase tracking-wide flex items-center gap-1.5">
                                    <i data-lucide="database" class="w-3.5 h-3.5 text-violet-400"></i> Memory Threshold
                                </span>
                                <span class="text-sm font-black" :class="site.mem >= 80 ? 'text-red-600' : 'text-slate-800'"
                                    x-text="site.mem + '%'"></span>
                            </div>
                            <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full rounded-full transition-all"
                                    :class="site.mem >= 80 ? 'bg-red-400' : 'bg-violet-400'"
                                    :style="'width:' + site.mem + '%'"></div>
                            </div>
                            <p class="text-[10px] text-slate-400">Alert jika Memory melebihi <span class="font-semibold"
                                    x-text="site.mem + '%'"></span></p>
                        </div>

                        {{-- Disk --}}
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <span
                                    class="text-xs font-bold text-slate-500 uppercase tracking-wide flex items-center gap-1.5">
                                    <i data-lucide="hard-drive" class="w-3.5 h-3.5 text-amber-400"></i> Disk Threshold
                                </span>
                                <span class="text-sm font-black"
                                    :class="site.disk >= 80 ? 'text-red-600' : 'text-slate-800'"
                                    x-text="site.disk + '%'"></span>
                            </div>
                            <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full rounded-full transition-all"
                                    :class="site.disk >= 80 ? 'bg-red-400' : 'bg-amber-400'"
                                    :style="'width:' + site.disk + '%'"></div>
                            </div>
                            <p class="text-[10px] text-slate-400">Alert jika Disk melebihi <span class="font-semibold"
                                    x-text="site.disk + '%'"></span></p>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        {{-- Edit Modal --}}
        <div x-show="isModalOpen" style="display:none;" class="fixed inset-0 z-50 flex items-center justify-center px-4"
            x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-150"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" @click="closeModal()"></div>
            <div class="bg-white rounded-2xl shadow-xl sm:w-full sm:max-w-md z-10 overflow-hidden"
                x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0 scale-90"
                x-transition:enter-end="opacity-100 scale-100">
                <div class="px-6 py-4 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-slate-800">Ubah Threshold — <span class="text-blue-600"
                            x-text="form.nama"></span></h3>
                    <button @click="closeModal()" class="text-slate-400 hover:text-slate-600"><i data-lucide="x"
                            class="w-5 h-5"></i></button>
                </div>
                <div class="p-6 space-y-5">
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-600 uppercase tracking-wider flex justify-between">
                            <span class="flex items-center gap-1.5"><i data-lucide="cpu"
                                    class="w-3.5 h-3.5 text-blue-400"></i> CPU Alert (%)</span>
                            <span class="font-black text-slate-800" x-text="form.cpu + '%'"></span>
                        </label>
                        <input type="range" min="50" max="100" step="5" x-model="form.cpu"
                            class="w-full h-2 rounded-full accent-blue-500 cursor-pointer">
                        <div class="flex justify-between text-[10px] text-slate-400">
                            <span>50%</span><span>75%</span><span>100%</span>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-600 uppercase tracking-wider flex justify-between">
                            <span class="flex items-center gap-1.5"><i data-lucide="database"
                                    class="w-3.5 h-3.5 text-violet-400"></i> Memory Alert (%)</span>
                            <span class="font-black text-slate-800" x-text="form.mem + '%'"></span>
                        </label>
                        <input type="range" min="50" max="100" step="5" x-model="form.mem"
                            class="w-full h-2 rounded-full accent-violet-500 cursor-pointer">
                        <div class="flex justify-between text-[10px] text-slate-400">
                            <span>50%</span><span>75%</span><span>100%</span>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-600 uppercase tracking-wider flex justify-between">
                            <span class="flex items-center gap-1.5"><i data-lucide="hard-drive"
                                    class="w-3.5 h-3.5 text-amber-400"></i> Disk Alert (%)</span>
                            <span class="font-black text-slate-800" x-text="form.disk + '%'"></span>
                        </label>
                        <input type="range" min="50" max="100" step="5" x-model="form.disk"
                            class="w-full h-2 rounded-full accent-amber-500 cursor-pointer">
                        <div class="flex justify-between text-[10px] text-slate-400">
                            <span>50%</span><span>75%</span><span>100%</span>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
                    <button @click="closeModal()"
                        class="px-4 py-2 text-slate-600 font-medium text-sm hover:bg-slate-200/50 rounded-lg">Batal</button>
                    <button @click="save()"
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-lg shadow-sm">Simpan</button>
                </div>
            </div>
        </div>

        {{-- Toast --}}
        <div x-show="toast.show" style="display:none;" class="fixed bottom-6 right-6 z-[60] max-w-sm w-full"
            x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 translate-y-4 scale-95">
            <div class="flex items-center gap-3 px-4 py-3.5 rounded-2xl shadow-xl border bg-emerald-50 border-emerald-200">
                <div class="w-9 h-9 rounded-xl bg-emerald-500 flex items-center justify-center">
                    <i data-lucide="check" class="w-4 h-4 text-white"></i>
                </div>
                <p class="text-sm font-semibold flex-1 text-emerald-800" x-text="toast.message"></p>
                <button @click="toast.show = false" class="opacity-40 hover:opacity-80"><i data-lucide="x"
                        class="w-4 h-4 text-slate-500"></i></button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => lucide.createIcons());
        document.addEventListener('alpine:init', () => {
            Alpine.data('thresholdManager', () => ({
                isModalOpen: false,
                form: {
                    id: null,
                    nama: '',
                    key: '',
                    cpu: 80,
                    mem: 80,
                    disk: 85
                },
                toast: {
                    show: false,
                    message: '',
                    timer: null
                },
                data: @json(
                    $sites->map(fn($s) => [
                            'id' => $s->id,
                            'nama' => $s->name,
                            'key' => $s->key,
                            'cpu' => $s->thresholdAlert->cpu_limit ?? 80,
                            'mem' => $s->thresholdAlert->mem_limit ?? 80,
                            'disk' => $s->thresholdAlert->disk_limit ?? 80,
                        ])),
                showToast(message) {
                    clearTimeout(this.toast.timer);
                    this.toast = {
                        show: true,
                        message,
                        timer: null
                    };
                    this.$nextTick(() => lucide.createIcons());
                    this.toast.timer = setTimeout(() => this.toast.show = false, 4000);
                },
                editThreshold(site) {
                    this.form = {
                        ...site
                    };
                    this.isModalOpen = true;
                },
                closeModal() {
                    this.isModalOpen = false;
                },
                async save() {
                    try {
                        const res = await fetch('/api/master-data/threshold', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                site_id: this.form.id,
                                cpu_limit: this.form.cpu,
                                mem_limit: this.form.mem,
                                disk_limit: this.form.disk
                            })
                        });

                        if (res.ok) {
                            const i = this.data.findIndex(d => d.id === this.form.id);
                            if (i !== -1) this.data[i] = {
                                ...this.form
                            };
                            this.closeModal();
                            this.showToast(
                            `Threshold Proxmox ${this.form.nama} berhasil disimpan.`);
                        }
                    } catch (e) {
                        this.showToast('Gagal menyimpan threshold.');
                    }
                },
            }));
        });
    </script>
@endsection
