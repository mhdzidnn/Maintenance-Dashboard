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
                <!-- DataTable Controls -->
                <div
                    class="px-6 py-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-slate-500">Show</span>
                        <select x-model="perPage" @change="currentPage = 1"
                            class="bg-slate-50 border border-slate-200 rounded-lg px-2 py-1 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                        <span class="text-sm text-slate-500">entries</span>
                    </div>
                    <div class="relative max-w-sm w-full">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="search" class="w-4 h-4 text-slate-400"></i>
                        </div>
                        <input type="text" x-model="search" @input="currentPage = 1"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-2 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all placeholder:text-slate-400"
                            placeholder="Search name, username, email...">
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200">
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama
                                    User</th>
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
                            <template x-for="cred in paginatedCredentials" :key="cred.id">
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
                                            <button @click="confirmDelete(cred)"
                                                class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                                                title="Delete">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                            <tr x-show="filteredCredentials.length === 0">
                                <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                    <div class="flex flex-col items-center justify-center space-y-2">
                                        <div class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center">
                                            <i data-lucide="shield-alert" class="w-6 h-6 text-slate-300"></i>
                                        </div>
                                        <p>No matching credentials found.</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Footer Pagination -->
                <div
                    class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="text-sm text-slate-500">
                        Showing <span class="font-semibold text-slate-700" x-text="showingStart"></span> to
                        <span class="font-semibold text-slate-700" x-text="showingEnd"></span> of
                        <span class="font-semibold text-slate-700" x-text="filteredCredentials.length"></span> entries
                    </div>
                    <div class="flex items-center space-x-1">
                        <button @click="currentPage = 1" :disabled="currentPage === 1"
                            class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-all"
                            :class="currentPage === 1 ? 'text-slate-400 cursor-not-allowed' :
                                'text-slate-600 hover:bg-white hover:shadow-sm'">
                            First
                        </button>
                        <button @click="currentPage--" :disabled="currentPage === 1"
                            class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-all"
                            :class="currentPage === 1 ? 'text-slate-400 cursor-not-allowed' :
                                'text-slate-600 hover:bg-white hover:shadow-sm'">
                            Previous
                        </button>

                        <template x-for="page in totalPages" :key="page">
                            <button @click="currentPage = page"
                                class="w-8 h-8 rounded-lg text-xs font-semibold transition-all"
                                :class="currentPage === page ? 'bg-blue-600 text-white shadow-sm' :
                                    'text-slate-600 hover:bg-white hover:shadow-sm'"
                                x-text="page">
                            </button>
                        </template>

                        <button @click="currentPage++" :disabled="currentPage === totalPages"
                            class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-all"
                            :class="currentPage === totalPages ? 'text-slate-400 cursor-not-allowed' :
                                'text-slate-600 hover:bg-white hover:shadow-sm'">
                            Next
                        </button>
                        <button @click="currentPage = totalPages" :disabled="currentPage === totalPages"
                            class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-all"
                            :class="currentPage === totalPages ? 'text-slate-400 cursor-not-allowed' :
                                'text-slate-600 hover:bg-white hover:shadow-sm'">
                            Last
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add/Edit Modal -->
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
                        x-text="isEditing ? 'Edit Credential' : 'Tambah Credential'"></h3>
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

        <!-- Delete Confirmation Modal -->
        <div x-show="isDeleteModalOpen" style="display: none;"
            class="fixed inset-0 z-50 flex items-center justify-center px-4 sm:px-6"
            x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-150"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

            <!-- Backdrop -->
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

            <!-- Panel -->
            <div class="bg-white rounded-2xl shadow-2xl sm:w-full sm:max-w-md z-10 overflow-hidden relative"
                x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0 scale-90"
                x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90">

                <div class="p-6 text-center">
                    <!-- Icon -->
                    <div class="mx-auto w-14 h-14 flex items-center justify-center bg-red-100 rounded-full mb-4">
                        <i data-lucide="trash-2" class="w-7 h-7 text-red-500"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-1">Hapus Credential?</h3>
                    <p class="text-slate-500 text-sm mb-1">Anda akan menghapus data:</p>
                    <p class="text-slate-800 font-semibold text-sm mb-5"
                        x-text="'\"' + (deleteTarget?.name ?? '') + '\"'"></p>
                    <p class="text-slate-400 text-xs mb-6">Tindakan ini tidak dapat dibatalkan.</p>

                    <div class="flex items-center justify-center space-x-3">
                        <button @click="cancelDelete()"
                            class="px-5 py-2.5 text-slate-600 font-semibold text-sm bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                            Batal
                        </button>
                        <button @click="executeDelete()"
                            class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold text-sm rounded-xl shadow-sm shadow-red-600/20 transition-all active:scale-95">
                            Ya, Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Toast Notification -->
        <div x-show="toast.show" style="display: none;" class="fixed bottom-6 right-6 z-[60] max-w-sm w-full"
            x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 scale-95">

            <div class="flex items-center space-x-3 px-4 py-3.5 rounded-2xl shadow-xl border"
                :class="{
                    'bg-emerald-50 border-emerald-200 text-emerald-800': toast.type === 'success',
                    'bg-red-50 border-red-200 text-red-800': toast.type === 'danger',
                }">
                <div class="flex-shrink-0 w-9 h-9 rounded-xl flex items-center justify-center"
                    :class="{
                        'bg-emerald-500': toast.type === 'success',
                        'bg-red-500': toast.type === 'danger',
                    }">
                    <i class="w-5 h-5 text-white" :data-lucide="toast.type === 'success' ? 'check' : 'trash-2'"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-black uppercase tracking-widest opacity-60"
                        x-text="toast.type === 'success' ? 'Berhasil' : 'Dihapus'"></p>
                    <p class="text-sm font-semibold leading-snug" x-text="toast.message"></p>
                </div>
                <button @click="toast.show = false" class="flex-shrink-0 opacity-40 hover:opacity-80 transition-opacity">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
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
                search: '',
                perPage: 10,
                currentPage: 1,
                isModalOpen: false,
                isEditing: false,
                isDeleteModalOpen: false,
                deleteTarget: null,
                form: {
                    id: null,
                    name: '',
                    username: '',
                    email: '',
                    password: ''
                },
                toast: {
                    show: false,
                    message: '',
                    type: 'success',
                    timer: null,
                },

                init() {
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
                        },
                        {
                            id: 4,
                            name: 'Michael Jordan',
                            username: 'mj23',
                            email: 'mj@persero.com',
                            password: 'goat_password'
                        },
                        {
                            id: 5,
                            name: 'Cristiano Ronaldo',
                            username: 'cr7',
                            email: 'cr7@persero.com',
                            password: 'siuuu_password'
                        },
                        {
                            id: 6,
                            name: 'Lionel Messi',
                            username: 'messi10',
                            email: 'messi@persero.com',
                            password: 'lapulga_password'
                        },
                        {
                            id: 7,
                            name: 'Steve Jobs',
                            username: 'steve',
                            email: 'steve@apple.com',
                            password: 'think_different'
                        },
                        {
                            id: 8,
                            name: 'Bill Gates',
                            username: 'bill',
                            email: 'bill@microsoft.com',
                            password: 'windows_password'
                        },
                        {
                            id: 9,
                            name: 'Elon Musk',
                            username: 'elon',
                            email: 'elon@tesla.com',
                            password: 'mars_password'
                        },
                        {
                            id: 10,
                            name: 'Jeff Bezos',
                            username: 'jeff',
                            email: 'jeff@amazon.com',
                            password: 'prime_password'
                        },
                        {
                            id: 11,
                            name: 'Mark Zuckerberg',
                            username: 'mark',
                            email: 'mark@meta.com',
                            password: 'meta_password'
                        },
                        {
                            id: 12,
                            name: 'Larry Page',
                            username: 'larry',
                            email: 'larry@google.com',
                            password: 'search_password'
                        }
                    ];

                    if (this.ip.endsWith('53')) {
                        this.credentials = dummyData.slice(0, 5);
                    } else if (this.ip.endsWith('54')) {
                        this.credentials = dummyData.slice(5, 12);
                    } else {
                        this.credentials = dummyData;
                    }

                    this.$nextTick(() => {
                        lucide.createIcons();
                    });
                },

                get filteredCredentials() {
                    const searchTerm = this.search.toLowerCase();
                    return this.credentials.filter(c =>
                        c.name.toLowerCase().includes(searchTerm) ||
                        c.username.toLowerCase().includes(searchTerm) ||
                        c.email.toLowerCase().includes(searchTerm)
                    );
                },

                get paginatedCredentials() {
                    const start = (this.currentPage - 1) * this.perPage;
                    const end = start + parseInt(this.perPage);
                    return this.filteredCredentials.slice(start, end);
                },

                get totalPages() {
                    return Math.ceil(this.filteredCredentials.length / this.perPage);
                },

                get showingStart() {
                    if (this.filteredCredentials.length === 0) return 0;
                    return (this.currentPage - 1) * this.perPage + 1;
                },

                get showingEnd() {
                    const end = this.currentPage * this.perPage;
                    return end > this.filteredCredentials.length ? this.filteredCredentials.length :
                        end;
                },

                showToast(message, type = 'success') {
                    clearTimeout(this.toast.timer);
                    this.toast = {
                        show: true,
                        message,
                        type,
                        timer: null
                    };
                    this.$nextTick(() => {
                        lucide.createIcons();
                    });
                    this.toast.timer = setTimeout(() => {
                        this.toast.show = false;
                    }, 4000);
                },

                openModal() {
                    this.isModalOpen = true;
                    this.isEditing = false;
                    this.resetForm();
                    this.$nextTick(() => lucide.createIcons());
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
                    this.$nextTick(() => lucide.createIcons());
                },

                save() {
                    if (!this.form.name || !this.form.username) return;

                    if (this.isEditing) {
                        const index = this.credentials.findIndex(c => c.id === this.form.id);
                        if (index !== -1) {
                            this.credentials[index] = {
                                ...this.form
                            };
                        }
                        this.closeModal();
                        this.showToast(`Data "${this.form.name}" berhasil diupdate.`, 'success');
                    } else {
                        const newId = Math.max(...this.credentials.map(c => c.id), 0) + 1;
                        const savedName = this.form.name;
                        this.credentials.push({
                            ...this.form,
                            id: newId
                        });
                        this.closeModal();
                        this.showToast(`Data "${savedName}" berhasil ditambahkan.`, 'success');
                    }

                    this.$nextTick(() => {
                        lucide.createIcons();
                    });
                },

                confirmDelete(cred) {
                    this.deleteTarget = cred;
                    this.isDeleteModalOpen = true;
                    this.$nextTick(() => {
                        lucide.createIcons();
                    });
                },

                cancelDelete() {
                    this.deleteTarget = null;
                    this.isDeleteModalOpen = false;
                },

                executeDelete() {
                    if (!this.deleteTarget) return;
                    const name = this.deleteTarget.name;
                    this.credentials = this.credentials.filter(c => c.id !== this.deleteTarget.id);
                    this.isDeleteModalOpen = false;
                    this.deleteTarget = null;
                    this.showToast(`Data "${name}" berhasil dihapus.`, 'danger');

                    // Adjust page if current page becomes empty
                    if (this.paginatedCredentials.length === 0 && this.currentPage > 1) {
                        this.currentPage--;
                    }
                },
            }))
        });
    </script>
@endsection
