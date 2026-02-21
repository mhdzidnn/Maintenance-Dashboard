@extends('layouts.app')

@section('content')
    <div x-data="lokasiManager()" class="space-y-6">

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Lokasi Proxmox</h1>
                <p class="text-slate-500 text-sm mt-0.5">Master data lokasi / site infrastruktur Proxmox</p>
            </div>
            <button @click="openModal()"
                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors flex items-center shadow-sm">
                <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                Tambah Lokasi
            </button>
        </div>

        {{-- Table --}}
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Site
                            </th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Location Key
                            </th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">IP Node</th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Deskripsi
                            </th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <template x-for="lokasi in data" :key="lokasi.id">
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center border border-blue-100">
                                            <i data-lucide="server" class="w-4 h-4 text-blue-600"></i>
                                        </div>
                                        <span class="font-semibold text-sm text-slate-800" x-text="lokasi.nama"></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-xs font-mono bg-slate-100 text-slate-600 px-2 py-1 rounded"
                                        x-text="lokasi.key"></span>
                                </td>
                                <td class="px-6 py-4 text-sm font-mono text-slate-600" x-text="lokasi.ip"></td>
                                <td class="px-6 py-4 text-sm text-slate-500 max-w-xs truncate" x-text="lokasi.deskripsi">
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        <button @click="edit(lokasi)"
                                            class="p-2 text-amber-500 hover:bg-amber-50 rounded-lg transition-colors"
                                            title="Edit">
                                            <i data-lucide="edit" class="w-4 h-4"></i>
                                        </button>
                                        <button @click="confirmDelete(lokasi)"
                                            class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                                            title="Hapus">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                        <tr x-show="data.length === 0">
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400 text-sm">Belum ada data lokasi.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Add/Edit Modal --}}
        <div x-show="isModalOpen" style="display:none;" class="fixed inset-0 z-50 flex items-center justify-center px-4"
            x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-150"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" @click="closeModal()"></div>
            <div class="bg-white rounded-2xl shadow-xl sm:w-full sm:max-w-lg z-10 overflow-hidden"
                x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0 scale-90"
                x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90">
                <div class="px-6 py-4 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-slate-800" x-text="isEditing ? 'Edit Lokasi' : 'Tambah Lokasi'"></h3>
                    <button @click="closeModal()" class="text-slate-400 hover:text-slate-600"><i data-lucide="x"
                            class="w-5 h-5"></i></button>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-slate-600 uppercase tracking-wider block">Nama Site</label>
                            <input type="text" x-model="form.nama"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500"
                                placeholder="e.g. AGS">
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-slate-600 uppercase tracking-wider block">Location
                                Key</label>
                            <input type="text" x-model="form.key"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 font-mono"
                                placeholder="e.g. ags">
                        </div>
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-600 uppercase tracking-wider block">IP Node</label>
                        <input type="text" x-model="form.ip"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 font-mono"
                            placeholder="e.g. 10.13.15.10">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-600 uppercase tracking-wider block">Deskripsi</label>
                        <textarea x-model="form.deskripsi" rows="2"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 resize-none"
                            placeholder="Deskripsi singkat lokasi..."></textarea>
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

        {{-- Delete Confirmation Modal --}}
        <div x-show="isDeleteModalOpen" style="display:none;"
            class="fixed inset-0 z-50 flex items-center justify-center px-4" x-transition:enter="ease-out duration-200"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-150" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
            <div class="bg-white rounded-2xl shadow-2xl sm:w-full sm:max-w-md z-10 overflow-hidden relative p-6 text-center"
                x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0 scale-90"
                x-transition:enter-end="opacity-100 scale-100">
                <div class="mx-auto w-14 h-14 flex items-center justify-center bg-red-100 rounded-full mb-4">
                    <i data-lucide="trash-2" class="w-7 h-7 text-red-500"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-1">Hapus Lokasi?</h3>
                <p class="text-slate-500 text-sm mb-1">Anda akan menghapus lokasi:</p>
                <p class="text-slate-800 font-semibold text-sm mb-6" x-text="'\"' + (deleteTarget?.nama ?? '') + '\"'">
                </p>
                <div class="flex justify-center gap-3">
                    <button @click="cancelDelete()"
                        class="px-5 py-2.5 text-slate-600 font-semibold text-sm bg-slate-100 hover:bg-slate-200 rounded-xl">Batal</button>
                    <button @click="executeDelete()"
                        class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold text-sm rounded-xl">Ya,
                        Hapus</button>
                </div>
            </div>
        </div>

        {{-- Toast --}}
        <div x-show="toast.show" style="display:none;" class="fixed bottom-6 right-6 z-[60] max-w-sm w-full"
            x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 translate-y-4 scale-95">
            <div class="flex items-center gap-3 px-4 py-3.5 rounded-2xl shadow-xl border"
                :class="toast.type === 'success' ? 'bg-emerald-50 border-emerald-200' : 'bg-red-50 border-red-200'">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center"
                    :class="toast.type === 'success' ? 'bg-emerald-500' : 'bg-red-500'">
                    <i :data-lucide="toast.type === 'success' ? 'check' : 'trash-2'" class="w-4 h-4 text-white"></i>
                </div>
                <p class="text-sm font-semibold flex-1"
                    :class="toast.type === 'success' ? 'text-emerald-800' : 'text-red-800'" x-text="toast.message"></p>
                <button @click="toast.show = false" class="opacity-40 hover:opacity-80"><i data-lucide="x"
                        class="w-4 h-4 text-slate-500"></i></button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => lucide.createIcons());
        document.addEventListener('alpine:init', () => {
            Alpine.data('lokasiManager', () => ({
                isModalOpen: false,
                isEditing: false,
                isDeleteModalOpen: false,
                deleteTarget: null,
                form: {
                    id: null,
                    nama: '',
                    key: '',
                    ip: '',
                    deskripsi: ''
                },
                toast: {
                    show: false,
                    message: '',
                    type: 'success',
                    timer: null
                },
                data: [{
                        id: 1,
                        nama: 'AGS',
                        key: 'ags',
                        ip: '10.13.15.10',
                        deskripsi: 'Kantor cabang AGS, berisi VM operasional utama'
                    },
                    {
                        id: 2,
                        nama: 'Kantor Pusat',
                        key: 'pusat',
                        ip: '10.13.15.20',
                        deskripsi: 'Server pusat dengan beban tinggi, 4 VM aktif'
                    },
                    {
                        id: 3,
                        nama: 'Punggur',
                        key: 'punggur',
                        ip: '10.13.15.30',
                        deskripsi: 'Site Punggur, sebagian VM sedang tidak aktif'
                    },
                    {
                        id: 4,
                        nama: 'Sekupang',
                        key: 'sekupang',
                        ip: '10.13.15.40',
                        deskripsi: 'Site Sekupang, kondisi normal dan seimbang'
                    },
                ],
                showToast(message, type = 'success') {
                    clearTimeout(this.toast.timer);
                    this.toast = {
                        show: true,
                        message,
                        type,
                        timer: null
                    };
                    this.$nextTick(() => lucide.createIcons());
                    this.toast.timer = setTimeout(() => this.toast.show = false, 4000);
                },
                openModal() {
                    this.isModalOpen = true;
                    this.isEditing = false;
                    this.form = {
                        id: null,
                        nama: '',
                        key: '',
                        ip: '',
                        deskripsi: ''
                    };
                },
                closeModal() {
                    this.isModalOpen = false;
                },
                edit(item) {
                    this.isEditing = true;
                    this.form = {
                        ...item
                    };
                    this.isModalOpen = true;
                },
                save() {
                    if (!this.form.nama || !this.form.key) return;
                    if (this.isEditing) {
                        const i = this.data.findIndex(d => d.id === this.form.id);
                        if (i !== -1) this.data[i] = {
                            ...this.form
                        };
                        this.closeModal();
                        this.showToast(`Lokasi "${this.form.nama}" berhasil diupdate.`);
                    } else {
                        const newId = Math.max(...this.data.map(d => d.id), 0) + 1;
                        const saved = this.form.nama;
                        this.data.push({
                            ...this.form,
                            id: newId
                        });
                        this.closeModal();
                        this.showToast(`Lokasi "${saved}" berhasil ditambahkan.`);
                    }
                    this.$nextTick(() => lucide.createIcons());
                },
                confirmDelete(item) {
                    this.deleteTarget = item;
                    this.isDeleteModalOpen = true;
                    this.$nextTick(() => lucide.createIcons());
                },
                cancelDelete() {
                    this.deleteTarget = null;
                    this.isDeleteModalOpen = false;
                },
                executeDelete() {
                    const name = this.deleteTarget.nama;
                    this.data = this.data.filter(d => d.id !== this.deleteTarget.id);
                    this.isDeleteModalOpen = false;
                    this.deleteTarget = null;
                    this.showToast(`Lokasi "${name}" berhasil dihapus.`, 'danger');
                },
            }));
        });
    </script>
@endsection
