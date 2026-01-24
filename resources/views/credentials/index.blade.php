@extends('layouts.app')

@section('content')
    <div x-data="credentialManager('{{ $ip }}')">
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">SUMMARY PASSWORD VM {{ $ip }}</h1>
                    <p class="text-slate-500">Manage access credentials for this server</p>
                </div>
                <button @click="openModal()"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors flex items-center shadow-sm">
                    <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                    Add Credential
                </button>
            </div>

            <!-- Content Card -->
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200">
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama
                                    User
                                </th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Username
                                </th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Email
                                </th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Password
                                </th>
                                <th
                                    class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <template x-for="cred in credentials" :key="cred.id">
                                <tr class="hover:bg-slate-50 transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-3">
                                            <div
                                                class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs uppercase border border-blue-100">
                                                <span x-text="cred.name.substring(0,2)"></span>
                                            </div>
                                            <div class="text-sm font-medium text-slate-800" x-text="cred.name"></div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-slate-600 font-mono bg-slate-100 px-2 py-1 rounded inline-block"
                                            x-text="cred.username"></div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-slate-600 flex items-center">
                                            <i data-lucide="mail" class="w-3.5 h-3.5 mr-2 text-slate-400"></i>
                                            <span x-text="cred.email"></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4" x-data="{ show: false }">
                                        <div class="flex items-center space-x-2">
                                            <span class="text-sm font-mono text-slate-600"
                                                x-text="show ? cred.password : '••••••••'"></span>
                                            <button @click="show = !show"
                                                class="text-slate-400 hover:text-blue-600 transition-colors">
                                                <i :data-lucide="show ? 'eye-off' : 'eye'" class="w-4 h-4"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end space-x-2">
                                            <button @click="edit(cred)"
                                                class="p-2 text-amber-500 hover:bg-amber-50 rounded-lg transition-colors"
                                                title="Edit">
                                                <i data-lucide="edit" class="w-4 h-4"></i>
                                            </button>
                                            <button @click="remove(cred.id)"
                                                class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                                                title="Delete">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                            <tr x-show="credentials.length === 0">
                                <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                    <div class="flex flex-col items-center justify-center space-y-2">
                                        <div class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center">
                                            <i data-lucide="shield-alert" class="w-6 h-6 text-slate-300"></i>
                                        </div>
                                        <p>No credentials found for this server.</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div x-show="isModalOpen" style="display: none;"
            class="fixed inset-0 z-50 flex items-center justify-center px-4 sm:px-6"
            x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

            <!-- Backdrop -->
            <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity" @click="closeModal()"></div>

            <!-- Modal Panel -->
            <div class="bg-white rounded-2xl shadow-xl transform transition-all sm:w-full sm:max-w-lg z-10 overflow-hidden"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

                <div class="px-6 py-4 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-slate-800"
                        x-text="isEditing ? 'Edit Credential' : 'Tambah Credential'">
                    </h3>
                    <button @click="closeModal()" class="text-slate-400 hover:text-slate-600 transition-colors">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <div class="p-6 space-y-4">
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-600 uppercase tracking-wider block">Nama User</label>
                        <input type="text" x-model="form.name"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all placeholder:text-slate-400"
                            placeholder="e.g. John Doe">
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-600 uppercase tracking-wider block">Email</label>
                        <input type="email" x-model="form.email"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all placeholder:text-slate-400"
                            placeholder="e.g. john@persero.com">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-slate-600 uppercase tracking-wider block">Username</label>
                            <input type="text" x-model="form.username"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all placeholder:text-slate-400"
                                placeholder="e.g. johndoe">
                        </div>

                        <div class="space-y-1.5" x-data="{ show: false }">
                            <label class="text-xs font-bold text-slate-600 uppercase tracking-wider block">Password</label>
                            <div class="relative">
                                <input :type="show ? 'text' : 'password'" x-model="form.password"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all placeholder:text-slate-400 pr-10"
                                    placeholder="••••••••">
                                <button @click="show = !show" type="button"
                                    class="absolute top-1/2 right-3 -translate-y-1/2 text-slate-400 hover:text-blue-600">
                                    <i :data-lucide="show ? 'eye-off' : 'eye'" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end space-x-3">
                    <button @click="closeModal()"
                        class="px-4 py-2 text-slate-600 font-medium text-sm hover:text-slate-800 hover:bg-slate-200/50 rounded-lg transition-colors">
                        Batal
                    </button>
                    <button @click="save()"
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-lg shadow-sm shadow-blue-600/20 transition-all transform active:scale-95">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });

        document.addEventListener('alpine:init', () => {
            Alpine.data('credentialManager', (ip) => ({
                ip: ip,
                credentials: [],
                isModalOpen: false,
                isEditing: false,
                form: {
                    id: null,
                    name: '',
                    username: '',
                    email: '',
                    password: ''
                },

                init() {
                    // Initialize with dummy data based on IP to simulate different "databases"
                    // In a real app, this would fetch from API
                    const dummyData = [{
                            id: 1,
                            name: 'Admin System',
                            username: 'admin_sys',
                            email: 'admin@persero.com',
                            password: 'password123'
                        },
                        {
                            id: 2,
                            name: 'John Doe',
                            username: 'johndoe',
                            email: 'john@persero.com',
                            password: 'password123'
                        },
                        {
                            id: 3,
                            name: 'Jane Smith',
                            username: 'janesmith',
                            email: 'jane@persero.com',
                            password: 'password123'
                        }
                    ];

                    // Simple hash to make data look slightly different per IP
                    if (this.ip.endsWith('53')) {
                        this.credentials = dummyData.slice(0, 2);
                    } else if (this.ip.endsWith('54')) {
                        this.credentials = [dummyData[0], dummyData[2]];
                    } else {
                        this.credentials = dummyData;
                    }

                    // Re-run lucide icons after Alpine initializes
                    this.$nextTick(() => {
                        lucide.createIcons();
                    });
                },

                openModal() {
                    this.isModalOpen = true;
                    this.isEditing = false;
                    this.resetForm();
                },

                closeModal() {
                    this.isModalOpen = false;
                    this.resetForm();
                },

                resetForm() {
                    this.form = {
                        id: null,
                        name: '',
                        username: '',
                        email: '',
                        password: ''
                    };
                },

                edit(cred) {
                    this.isEditing = true;
                    this.form = {
                        ...cred
                    };
                    this.isModalOpen = true;
                },

                save() {
                    if (!this.form.name || !this.form.username) return; // Simple validation

                    if (this.isEditing) {
                        const index = this.credentials.findIndex(c => c.id === this.form.id);
                        if (index !== -1) {
                            this.credentials[index] = {
                                ...this.form
                            };
                        }
                    } else {
                        const newId = Math.max(...this.credentials.map(c => c.id), 0) + 1;
                        this.credentials.push({
                            ...this.form,
                            id: newId
                        });
                    }

                    this.closeModal();
                    this.$nextTick(() => {
                        lucide.createIcons(); // Refresh icons for new rows
                    });
                },

                remove(id) {
                    if (confirm('Are you sure you want to delete this credential?')) {
                        this.credentials = this.credentials.filter(c => c.id !== id);
                    }
                }
            }))
        });
    </script>
@endsection
