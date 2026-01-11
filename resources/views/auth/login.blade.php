<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - IT Persero Batam</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        @keyframes blob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }

            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>
</head>

<body
    class="bg-[#020617] h-screen flex items-center justify-center p-4 overflow-hidden selection:bg-blue-500/30 selection:text-blue-200">

    <!-- Development Ribbon -->
    <div class="fixed top-0 right-0 z-[9999] pointer-events-none overflow-hidden w-40 h-40">
        <div
            class="absolute top-8 -right-14 bg-amber-500 text-slate-900 font-black text-[10px] py-1.5 w-[200px] text-center transform rotate-45 shadow-2xl border-y border-white/10 uppercase tracking-[0.2em] whitespace-nowrap">
            Development UI
        </div>
    </div>

    <!-- Animated background blobs -->
    <div class="fixed inset-0 z-0">
        <div
            class="absolute top-0 -left-4 w-72 h-72 bg-blue-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob">
        </div>
        <div
            class="absolute top-0 -right-4 w-72 h-72 bg-purple-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000">
        </div>
        <div
            class="absolute -bottom-8 left-20 w-72 h-72 bg-emerald-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000">
        </div>
    </div>

    <div class="w-full max-w-[440px] relative z-10" x-data="{ showPassword: false }">
        <!-- Floating glass card -->
        <div
            class="bg-white/[0.02] backdrop-blur-2xl border border-white/10 rounded-[2.5rem] p-10 shadow-[0_32px_64px_-16px_rgba(0,0,0,0.5)] transition-all duration-700 hover:border-white/20">

            <!-- Logo area -->
            <div class="flex flex-col items-center mb-10">
                <div class="relative group mb-6">
                    <div
                        class="absolute -inset-4 bg-gradient-to-tr from-blue-600 to-cyan-400 rounded-full blur-2xl opacity-20 group-hover:opacity-40 transition duration-500">
                    </div>
                    <div
                        class="relative w-24 h-24 bg-white rounded-3xl p-2.5 flex items-center justify-center shadow-2xl border border-white/20 transform group-hover:rotate-6 transition duration-500">
                        <img src="{{ asset('img/persero batam.jpeg') }}" class="w-full h-full object-contain"
                            alt="Logo">
                    </div>
                </div>

                <h2 class="text-3xl font-black text-white tracking-tight mb-2">Systems Access</h2>
                <p class="text-slate-400 text-sm font-medium">Monitoring & Maintenance Dashboard</p>
            </div>

            <!-- Login form -->
            <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
                @csrf

                @if (session('error'))
                    <div
                        class="p-4 bg-red-500/10 border border-red-500/20 rounded-2xl flex items-center gap-3 animate-bounce-short">
                        <i data-lucide="alert-circle" class="w-5 h-5 text-red-400"></i>
                        <p class="text-red-300 text-xs font-semibold">{{ session('error') }}</p>
                    </div>
                @endif

                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-500 uppercase tracking-[0.2em] ml-2">Secure
                        Identifier</label>
                    <div class="relative group">
                        <div
                            class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none transition-colors group-focus-within:text-blue-400">
                            <i data-lucide="shield" class="w-5 h-5 text-slate-500 transition-colors"></i>
                        </div>
                        <input type="text" name="username" required
                            class="w-full bg-slate-900/40 border border-white/5 text-white rounded-2xl py-4 pl-14 pr-4 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500/40 focus:bg-slate-900/80 outline-none transition-all duration-300 placeholder:text-slate-600 text-sm font-medium"
                            placeholder="Enter username">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-500 uppercase tracking-[0.2em] ml-2">Access
                        Key</label>
                    <div class="relative group">
                        <div
                            class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none transition-colors group-focus-within:text-blue-400">
                            <i data-lucide="key" class="w-5 h-5 text-slate-500 transition-colors"></i>
                        </div>
                        <input :type="showPassword ? 'text' : 'password'" name="password" required
                            class="w-full bg-slate-900/40 border border-white/5 text-white rounded-2xl py-4 pl-14 pr-14 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500/40 focus:bg-slate-900/80 outline-none transition-all duration-300 placeholder:text-slate-600 text-sm font-medium"
                            placeholder="Enter password">

                        <button type="button" @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 pr-5 flex items-center text-slate-500 hover:text-white transition-colors focus:outline-none">
                            <i x-show="!showPassword" data-lucide="eye" class="w-5 h-5"></i>
                            <i x-show="showPassword" data-lucide="eye-off" class="w-5 h-5" style="display: none;"></i>
                        </button>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-500 text-white font-black py-4.5 rounded-2xl shadow-[0_20px_40px_-15px_rgba(37,99,235,0.4)] transform transition-all duration-300 hover:-translate-y-1 active:scale-[0.98] mt-4 flex items-center justify-center space-x-3 group overflow-hidden relative">
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:animate-[shimmer_2s_infinite]">
                    </div>
                    <span class="tracking-widest uppercase text-sm">Login</span>
                    <i data-lucide="arrow-right" class="w-5 h-5 transition-transform group-hover:translate-x-1"></i>
                </button>
            </form>

            <div
                class="mt-12 flex items-center justify-between text-[10px] font-black text-slate-600 uppercase tracking-widest px-2">
                <div class="flex items-center space-x-2">
                    <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></div>
                    <span>System Online</span>
                </div>
                <span>&copy; {{ date('Y') }} IT Persero</span>
            </div>
        </div>

        <!-- Subtle footer note -->
        <p class="mt-8 text-center text-slate-500 text-xs font-medium tracking-tight">
            Restricted access portal for <span class="text-slate-400">authorized personnel</span> only.
        </p>
    </div>

    <script>
        lucide.createIcons();
    </script>

    <style>
        @keyframes shimmer {
            100% {
                transform: translateX(100%);
            }
        }

        .py-4\.5 {
            padding-top: 1.125rem;
            padding-bottom: 1.125rem;
        }
    </style>
</body>

</html>
