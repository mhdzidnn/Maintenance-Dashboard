<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - IT Persero Batam</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-950 font-sans antialiased h-screen flex items-center justify-center relative overflow-hidden">

    <!-- Background Effects -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
        <div
            class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-blue-600/20 rounded-full blur-[120px] animate-pulse">
        </div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-purple-600/20 rounded-full blur-[120px] animate-pulse"
            style="animation-delay: 2s;"></div>
    </div>

    <!-- Login Card -->
    <div
        class="w-full max-w-md bg-slate-900/50 backdrop-blur-xl border border-white/10 rounded-3xl p-8 shadow-2xl relative z-10 mx-4">

        <!-- Header -->
        <div class="text-center mb-10">
            <div
                class="w-20 h-20 bg-white rounded-2xl mx-auto flex items-center justify-center mb-6 shadow-lg shadow-blue-500/20">
                <img src="{{ asset('img/persero batam.jpeg') }}" class="w-16 h-16 object-contain" alt="Logo">
            </div>
            <h1 class="text-3xl font-black text-white tracking-tight mb-2">Welcome Back</h1>
            <p class="text-slate-400">Sign in to access the maintenance dashboard</p>
        </div>

        <!-- Form -->
        <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
            @csrf

            @if (session('error'))
                <div
                    class="p-4 bg-red-500/10 border border-red-500/20 rounded-xl text-red-400 text-sm text-center font-medium">
                    {{ session('error') }}
                </div>
            @endif

            <div class="space-y-2">
                <label class="text-sm font-bold text-slate-300 uppercase tracking-wider ml-1">Username</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 text-slate-500 group-focus-within:text-blue-400 transition-colors"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <input type="text" name="username" required
                        class="w-full bg-slate-800/50 border border-slate-700 text-white rounded-xl py-3.5 pl-12 pr-4 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 outline-none transition-all placeholder:text-slate-600 font-medium"
                        placeholder="Enter your username">
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-sm font-bold text-slate-300 uppercase tracking-wider ml-1">Password</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 text-slate-500 group-focus-within:text-blue-400 transition-colors"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input type="password" name="password" required
                        class="w-full bg-slate-800/50 border border-slate-700 text-white rounded-xl py-3.5 pl-12 pr-4 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 outline-none transition-all placeholder:text-slate-600 font-medium"
                        placeholder="Enter your password">
                </div>
            </div>

            <button type="submit"
                class="w-full bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white font-bold py-4 rounded-xl shadow-lg shadow-blue-500/30 transform transition-all duration-200 active:scale-[0.98] mt-4 flex items-center justify-center space-x-2">
                <span>Sign In</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </form>

        <div class="mt-8 text-center text-sm text-slate-500">
            &copy; {{ date('Y') }} IT Persero Batam. All rights reserved.
        </div>
    </div>
</body>

</html>
