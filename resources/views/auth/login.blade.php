<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - IT Persero Batam</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        .login-gradient {
            background: linear-gradient(135deg, #1e40af 0%, #172554 100%);
        }

        .glass-element {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        @keyframes fade-in-up {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fade-in-up 0.6s ease-out forwards;
        }
    </style>
</head>

<body
    class="bg-slate-100 min-h-screen flex items-center justify-center p-4 font-sans text-slate-900 selection:bg-blue-100 selection:text-blue-900 overflow-hidden relative">

    <div
        class="w-full max-w-[1100px] h-[650px] bg-white rounded-[2rem] shadow-2xl overflow-hidden flex relative z-10 animate-fade-in-up">
        <!-- Left Panel (Feature Highlights) - Hidden on Mobile -->
        <div
            class="hidden lg:flex w-[55%] login-gradient relative flex-col justify-between p-10 overflow-hidden text-white">

            <!-- Decorative Blobs -->
            <div
                class="absolute top-0 right-0 w-[400px] h-[400px] bg-blue-500/20 rounded-full blur-[80px] -mr-32 -mt-32">
            </div>
            <div
                class="absolute bottom-0 left-0 w-[300px] h-[300px] bg-cyan-500/10 rounded-full blur-[60px] -ml-20 -mb-20">
            </div>

            <!-- Content -->
            <div class="relative z-10 flex flex-col h-full justify-center space-y-10 max-w-md mx-auto">
                <div class="space-y-3">
                    <div class="inline-flex items-center px-3 py-1.5 rounded-full glass-element mb-2">
                        <span class="w-2 h-2 rounded-full bg-amber-400 mr-2 animate-pulse"></span>
                        <span class="text-[10px] font-bold uppercase tracking-widest text-blue-100">Enterprise System
                            V2.0</span>
                    </div>
                    <h1 class="text-4xl font-black tracking-tight leading-tight">
                        Powering Your <br />
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-200 to-white">IT
                            Operations</span>
                    </h1>
                    <p class="text-blue-100/80 text-sm leading-relaxed max-w-sm">
                        Advanced monitoring, reliable infrastructure management, and secure access control in one
                        unified dashboard.
                    </p>
                </div>

                <div class="space-y-4">
                    <div
                        class="flex items-center space-x-4 p-3 rounded-xl glass-element transition-transform hover:scale-[1.02] duration-300 cursor-default">
                        <div
                            class="w-10 h-10 rounded-lg bg-blue-500/20 flex items-center justify-center text-amber-400">
                            <i data-lucide="zap" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-sm">Fast Management</h3>
                            <p class="text-blue-200 text-xs">Streamlined workflow efficiency</p>
                        </div>
                    </div>

                    <div
                        class="flex items-center space-x-4 p-3 rounded-xl glass-element transition-transform hover:scale-[1.02] duration-300 delay-75 cursor-default">
                        <div
                            class="w-10 h-10 rounded-lg bg-blue-500/20 flex items-center justify-center text-emerald-400">
                            <i data-lucide="bell" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-sm">Real-time Pulse</h3>
                            <p class="text-blue-200 text-xs">Instant notifications & updates</p>
                        </div>
                    </div>

                    <div
                        class="flex items-center space-x-4 p-3 rounded-xl glass-element transition-transform hover:scale-[1.02] duration-300 delay-150 cursor-default">
                        <div class="w-10 h-10 rounded-lg bg-blue-500/20 flex items-center justify-center text-cyan-400">
                            <i data-lucide="shield-check" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-sm">Secure Access</h3>
                            <p class="text-blue-200 text-xs">Enterprise-grade security</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative z-10 text-[10px] text-blue-300/50 font-medium uppercase tracking-widest">
                IT Dashboard System &bull; Persero Batam
            </div>
        </div>

        <!-- Right Panel (Login Form) -->
        <div class="w-full lg:w-[45%] flex items-center justify-center p-8 lg:p-12 relative bg-white">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-600 via-blue-400 to-amber-400">
            </div>

            <div class="w-full max-w-[360px] space-y-6">
                <!-- Header -->
                <div class="text-center space-y-2">
                    <div class="inline-flex justify-center mb-4">
                        <div
                            class="w-20 h-20 bg-white rounded-2xl shadow-lg border border-slate-100 p-2 flex items-center justify-center transform hover:rotate-3 transition-transform duration-500">
                            <img src="{{ asset('img/persero batam.jpeg') }}" class="w-full h-full object-contain"
                                alt="Logo">
                        </div>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Welcome Back</h2>
                    <p class="text-slate-500 text-xs font-medium">Sign in to access your dashboard</p>
                </div>

                <!-- Form -->
                <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                    @csrf

                    @if (session('error'))
                        <div
                            class="p-3 bg-red-50 border border-red-100 rounded-xl flex items-center gap-3 animate-pulse">
                            <i data-lucide="alert-circle" class="w-4 h-4 text-red-500"></i>
                            <p class="text-red-600 text-xs font-bold">{{ session('error') }}</p>
                        </div>
                    @endif

                    <div class="space-y-4">
                        <div class="group">
                            <label
                                class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1.5 ml-1">Username</label>
                            <div
                                class="relative transition-all duration-300 focus-within:transform focus-within:-translate-y-0.5">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <i data-lucide="user"
                                        class="w-4 h-4 text-slate-400 group-focus-within:text-blue-600 transition-colors"></i>
                                </div>
                                <input type="text" name="username" required
                                    class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl py-3 pl-10 pr-4 focus:ring-2 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all placeholder:text-slate-400 text-sm font-semibold shadow-sm group-hover:bg-white"
                                    placeholder="Enter your username">
                            </div>
                        </div>

                        <div class="group" x-data="{ showPassword: false }">
                            <label
                                class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1.5 ml-1">Password</label>
                            <div
                                class="relative transition-all duration-300 focus-within:transform focus-within:-translate-y-0.5">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <i data-lucide="lock"
                                        class="w-4 h-4 text-slate-400 group-focus-within:text-blue-600 transition-colors"></i>
                                </div>
                                <input :type="showPassword ? 'text' : 'password'" name="password" required
                                    class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl py-3 pl-10 pr-10 focus:ring-2 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all placeholder:text-slate-400 text-sm font-semibold shadow-sm group-hover:bg-white"
                                    placeholder="Enter your password">
                                <button type="button" @click="showPassword = !showPassword"
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-blue-600 transition-colors focus:outline-none">
                                    <i x-show="!showPassword" data-lucide="eye" class="w-4 h-4"></i>
                                    <i x-show="showPassword" data-lucide="eye-off" class="w-4 h-4"
                                        style="display: none;"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-blue-600/30 transition-all hover:shadow-blue-600/40 transform hover:-translate-y-0.5 active:scale-[0.98] flex items-center justify-center gap-2 group">
                        <span class="tracking-wide text-sm">Log In</span>
                        <i data-lucide="arrow-right" class="w-4 h-4 transition-transform group-hover:translate-x-1"></i>
                    </button>
                </form>

                <!-- Footer -->
                <div class="pt-6 text-center space-y-4">
                    <div
                        class="flex items-center justify-center text-[9px] font-black text-slate-300 uppercase tracking-widest">
                        <span class="flex items-center gap-1.5 ">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                            IT DASHBOARD
                        </span>
                        <span class="mx-2">&copy; {{ date('Y') }}</span>
                    </div>
                    <p
                        class="text-slate-400 text-[10px] font-bold mt-4 bg-slate-50 inline-block px-3 py-1.5 rounded-full border border-slate-100">
                        <i data-lucide="lock" class="w-3 h-3 inline mr-1 -mt-0.5 text-slate-300"></i> Authorized
                        Personnel Only
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>
