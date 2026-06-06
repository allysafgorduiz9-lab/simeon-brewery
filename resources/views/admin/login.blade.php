<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simeon Brewers - Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #0f172a; /* Midnight Background */
        }
        .glass-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(16, 185, 129, 0.2); /* Emerald Border */
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen text-gray-100">

    <div class="glass-card w-full max-w-md p-8 rounded-3xl shadow-2xl">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-black text-emerald-400 tracking-tight">SIMEON BREWERS</h2>
            <p class="text-xs text-gray-400 uppercase tracking-widest mt-1">Administration Portal</p>
        </div>

        @if(session('error'))
            <div class="bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-xl text-sm mb-6">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-6">
            @csrf
            
            <div>
                <label class="block text-xs font-bold text-emerald-400 uppercase tracking-wider mb-2">Username / Email</label>
                <input type="text" name="email" placeholder="admin@simeon.com" required
                    class="w-full bg-slate-900/80 border border-emerald-900/50 rounded-xl p-3 text-white focus:outline-none focus:border-emerald-500 transition">
            </div>

            <div>
                <label class="block text-xs font-bold text-emerald-400 uppercase tracking-wider mb-2">Password</label>
                <input type="password" name="password" placeholder="••••••••" required
                    class="w-full bg-slate-900/80 border border-emerald-900/50 rounded-xl p-3 text-white focus:outline-none focus:border-emerald-500 transition">
            </div>

            <button type="submit" 
                class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-black py-4 rounded-xl text-lg transition-all shadow-lg shadow-emerald-900/40">
                ENTER DASHBOARD
            </button>
        </form>
    </div>

</body>
</html>