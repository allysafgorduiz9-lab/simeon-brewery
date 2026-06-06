<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simeon Brewers - Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        midnight: '#0b0f19',     /* Darker, richer midnight base */
                        emeraldGlow: '#10b981',  /* Neon vibrant emerald */
                        coffeeDark: '#23120b',   /* Deep espresso brown */
                        coffeeLight: '#d4a373',  /* Creamy latte gold accent */
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background: radial-gradient(circle at center, #1e293b 0%, #0b0f19 100%);
        }
        .glass-panel {
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(16, 185, 129, 0.15);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5), 
                        0 0 40px rgba(16, 185, 129, 0.05);
        }
        .coffee-glow:focus {
            box-shadow: 0 0 15px rgba(212, 163, 115, 0.3);
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen text-gray-100 p-4">

    <div class="glass-panel w-full max-w-md p-8 rounded-[2.5rem] relative overflow-hidden">
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-coffeeLight/10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-emeraldGlow/10 rounded-full blur-2xl pointer-events-none"></div>

        <div class="text-center mb-8 relative z-10">
            <div class="inline-flex p-1.5 rounded-full bg-gradient-to-tr from-emeraldGlow via-coffeeLight to-coffeeDark shadow-xl mb-4">
                <div class="w-24 h-24 rounded-full bg-slate-950 overflow-hidden flex items-center justify-center">
                    <img src="{{ asset('Simeon Cafe.jpg') }}" 
                         alt="Simeon Cafe Logo" 
                         class="w-full h-full object-cover transform scale-105"
                         onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1509042239860-f550ce710b93?q=80&w=200';">
                </div>
            </div>

            <h2 class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-emeraldGlow via-emerald-300 to-coffeeLight tracking-tight uppercase">
                Simeon Brewers
            </h2>
            <p class="text-[10px] text-gray-400 uppercase tracking-[0.25em] font-bold mt-1.5 flex items-center justify-center gap-2">
                <span class="w-1.5 h-1.5 rounded-full bg-emeraldGlow animate-pulse"></span>
                Administration Portal
            </p>
        </div>

        @if(session('error'))
            <div class="bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-2xl text-sm mb-6 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-5 relative z-10">
            @csrf
            
            <div>
                <label class="block text-[11px] font-bold text-coffeeLight uppercase tracking-wider mb-2">Username / Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-500">
                        ☕
                    </span>
                    <input type="text" name="email" placeholder="admin@simeon.com" register="true" required
                        class="coffee-glow w-full bg-slate-950/60 border border-emeraldGlow/20 rounded-2xl py-3.5 pl-10 pr-4 text-white placeholder-gray-600 focus:outline-none focus:border-coffeeLight transition-all duration-300 text-sm">
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-bold text-coffeeLight uppercase tracking-wider mb-2">Password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-500">
                        🔒
                    </span>
                    <input type="password" name="password" placeholder="••••••••" required
                        class="coffee-glow w-full bg-slate-950/60 border border-emeraldGlow/20 rounded-2xl py-3.5 pl-10 pr-4 text-white placeholder-gray-600 focus:outline-none focus:border-coffeeLight transition-all duration-300 text-sm">
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" 
                    class="w-full bg-gradient-to-r from-emerald-700 to-emerald-600 hover:from-emerald-600 hover:to-emerald-500 text-white font-black py-4 rounded-2xl text-md transition-all duration-300 shadow-xl shadow-emerald-950/50 hover:shadow-emeraldGlow/20 active:scale-[0.98]">
                    LOGIN
                </button>
            </div>
        </form>
    </div>

</body>
</html>