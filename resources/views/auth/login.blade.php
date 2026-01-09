<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - IT Persero Batam</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="bg-[#0f172a] font-sans antialiased h-screen flex items-center justify-center relative overflow-hidden selection:bg-blue-500/30 selection:text-blue-200">

    <!-- Background Effects -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div
            class="absolute top-[-20%] left-[-10%] w-[60%] h-[60%] bg-blue-600/20 rounded-full blur-[120px] animate-pulse">
        </div>
        <div class="absolute bottom-[-20%] right-[-10%] w-[60%] h-[60%] bg-purple-600/20 rounded-full blur-[120px] animate-pulse"
            style="animation-delay: 2s;"></div>
        <div class="absolute top-[40%] left-[30%] w-[40%] h-[40%] bg-emerald-500/10 rounded-full blur-[100px] animate-pulse"
            style="animation-delay: 4s;"></div>
    </div>

    <!-- Login Card -->
    <div
        class="w-full max-w-[420px] bg-white/[0.03] backdrop-blur-2xl border border-white/10 rounded-3xl p-8 shadow-2xl relative z-10 mx-4 transition-all duration-500 hover:border-white/20 hover:shadow-blue-500/10 hover:bg-white/[0.04]">

        <!-- Decoration -->
        <div
            class="absolute top-0 left-1/2 -translate-x-1/2 w-3/4 h-[1px] bg-gradient-to-r from-transparent via-blue-500/50 to-transparent">
        </div>

        <!-- Header -->
        <div class="text-center mb-10">
            <div class="relative w-24 h-24 mx-auto mb-6 group">
                <div
                    class="absolute inset-0 bg-gradient-to-tr from-blue-500 to-purple-500 rounded-2xl blur-lg opacity-40 group-hover:opacity-60 transition-opacity duration-500">
                </div>
                <div
                    class="relative w-full h-full bg-slate-900/90 rounded-2xl border border-white/10 flex items-center justify-center overflow-hidden shadow-xl">
                    <img src="{{ asset('img/persero batam.jpeg') }}" class="w-20 h-20 object-contain p-2"
                        alt="Logo">
                </div>
            </div>
            <h1
                class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-white to-slate-400 tracking-tight mb-2">
                Welcome Back</h1>
            <p class="text-slate-400 font-medium">Sign in to access the dashboard</p>
        </div>

        <!-- Form -->
        <form action="{{ route('login.post') }}" method="POST" class="space-y-5" x-data="{ showPassword: false }">
            @csrf

            @if (session('error'))
                <div
                    class="p-4 bg-red-500/10 border border-red-500/20 rounded-xl flex items-center gap-3 animate-fade-in-down">
                    <div class="p-1.5 bg-red-500/20 rounded-full shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-400" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" x2="12" y1="8" y2="12" />
                            <line x1="12" x2="12.01" y1="16" y2="16" />
                        </svg>
                    </div>
                    <p class="text-red-300 text-sm font-medium">{{ session('error') }}</p>
                </div>
            @endif

            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-400 uppercase tracking-wider ml-1">Username</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 text-slate-500 group-focus-within:text-blue-400 transition-colors duration-300"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <input type="text" name="username" required
                        class="w-full bg-slate-900/50 border border-slate-700/50 text-white rounded-xl py-3.5 pl-12 pr-4 focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 focus:bg-slate-900/80 outline-none transition-all duration-300 placeholder:text-slate-600 font-medium"
                        placeholder="Enter your username">
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-400 uppercase tracking-wider ml-1">Password</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 text-slate-500 group-focus-within:text-blue-400 transition-colors duration-300"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input :type="showPassword ? 'text' : 'password'" name="password" required
                        class="w-full bg-slate-900/50 border border-slate-700/50 text-white rounded-xl py-3.5 pl-12 pr-12 focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 focus:bg-slate-900/80 outline-none transition-all duration-300 placeholder:text-slate-600 font-medium"
                        placeholder="Enter your password">

                    <button type="button" @click="showPassword = !showPassword"
                        class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-500 hover:text-slate-300 transition-colors focus:outline-none">
                        <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.574-2.59M5.378 5.378A10.051 10.051 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.05 10.05 0 01-2.986 4.39M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                        </svg>
                        <!-- Fallback for initialization before Alpine loads -->
                        <svg x-show="false" class="h-5 w-5 block group-hover:hidden"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                    <!-- Initial state setting script for fallback -->
                    <script>
                        document.querySelector('[x-data]').style.display = 'block';
                    </script>
                </div>
            </div>

            <button type="submit"
                class="w-full bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white font-bold py-4 rounded-xl shadow-lg shadow-blue-500/30 transform transition-all duration-300 hover:translate-y-[-2px] hover:shadow-blue-500/40 active:scale-[0.98] mt-6 flex items-center justify-center space-x-2 border border-blue-400/20 group">
                <span class="tracking-wide">Sign In</span>
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 transform transition-transform duration-300 group-hover:translate-x-1"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </form>

        <div class="mt-8 text-center text-sm">
            <p class="text-slate-500">&copy; {{ date('Y') }} IT Persero Batam.</p>
        </div>
    </div>
</body>

</html>
