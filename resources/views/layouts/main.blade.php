<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simeon Brewers Coffee</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        coffee: {
                            100: '#faf8f5', // Premium light linen cream
                            200: '#f1e6da', // Smooth latte accent
                            300: '#d4bda7', // Silky foam accent
                            700: '#4a3319', // Rich roast brown
                            800: '#2b1a08', // Dark espresso
                            900: '#140c04'  // Double espresso base
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body { font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; }
    </style>
</head>

<body class="bg-coffee-100 text-coffee-800 antialiased selection:bg-coffee-700 selection:text-white flex flex-col min-h-screen">

@php
    $setting = \App\Models\Setting::first();
    $storeStatus = optional($setting)->store_status ?? 'open';
@endphp

<nav class="bg-coffee-900/95 text-white sticky top-0 z-50 shadow-md backdrop-blur-md border-b border-coffee-800/40">
    <div class="container mx-auto px-6 h-20 flex justify-between items-center">

        <a href="/" class="flex items-center gap-3 group">
            <img src="{{ asset('Simeon Cafe.jpg') }}" alt="Simeon Cafe" class="w-10 h-10 rounded-full object-cover border-2 border-amber-500 shadow-md transition-transform duration-300 group-hover:scale-105" onerror="this.src='https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=100&auto=format&fit=crop&q=60'">
            <span class="text-xl md:text-2xl font-black tracking-wider text-white">
                <span class="text-amber-500">Simeon</span> Brewers
            </span>
        </a>

        <div class="hidden md:flex gap-8 text-sm font-semibold items-center tracking-wide">
            <a href="/" class="text-amber-400 border-b-2 border-amber-500 py-1">Home</a>
            <a href="/menu" class="text-gray-300 hover:text-amber-400 transition-colors duration-200 py-1">Menu</a>
            <a href="/about" class="text-gray-300 hover:text-amber-400 transition-colors duration-200 py-1">About</a>

            <span class="h-4 w-px bg-coffee-800"></span>

            <a href="/admin" class="text-gray-400 hover:text-white transition-colors duration-200 p-2 rounded-lg hover:bg-coffee-800/50" title="Staff Login">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </a>

            @if($storeStatus == 'open')
                <a href="/cart"
                   class="bg-amber-600 hover:bg-amber-500 text-white px-5 py-2.5 rounded-lg font-bold transition-all duration-200 shadow-sm hover:shadow active:scale-95 flex items-center gap-2">
                     Cart 
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
                </a>
            @else
                <button disabled
                        class="bg-zinc-800 px-5 py-2.5 rounded-lg font-bold text-zinc-400 cursor-not-allowed flex items-center gap-2 border border-zinc-700/60 shadow-inner">
                    Store Closed
                </button>
            @endif
        </div>
    </div>
</nav>

<header class="relative bg-cover bg-center bg-no-repeat flex-grow flex items-center justify-center py-24 md:py-36 text-center shadow-inner" 
        style="background-image: linear-gradient(rgba(20, 12, 4, 0.75), rgba(20, 12, 4, 0.85)), url('https://images.unsplash.com/photo-1498804103079-a6351b050096?q=80&w=1974&auto=format&fit=crop');">
    
    <div class="container mx-auto px-6 max-w-4xl">
        @if($storeStatus == 'closed')
            <div class="inline-flex items-center gap-2 bg-rose-500/10 border border-rose-500/30 text-rose-300 px-4 py-1.5 rounded-full text-xs font-semibold uppercase tracking-wider mb-8 backdrop-blur-sm animate-pulse">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/></svg>
                Ordering is currently closed
            </div>
        @endif

        <h1 class="text-5xl md:text-7xl font-black text-white tracking-tight mb-4 drop-shadow-md">
            Simeon Brewers
        </h1>
        <p class="text-amber-200/80 text-lg md:text-xl font-medium max-w-xl mx-auto mb-10 tracking-wide">
            Premium roasted coffee for the perfect morning.
        </p>
        
        <div class="bg-white/[0.03] backdrop-blur-xl rounded-2xl p-8 md:p-10 border border-white/10 shadow-2xl max-w-2xl mx-auto transform transition duration-300 hover:border-amber-500/30">
            <h2 class="text-2xl font-extrabold text-amber-400 mb-3 tracking-wide">Our Coffee</h2>
            <p class="text-gray-300 text-sm md:text-base leading-relaxed font-light">
                We serve freshly roasted beans sourced from the best local farms. Experience the rich taste of Simeon Brewers.
            </p>
        </div>
    </div>
</header>

<main class="bg-coffee-100">
    @yield('content')
</main>

<footer class="bg-coffee-900 text-gray-400 py-16 border-t border-coffee-800/40 mt-auto">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-12">
            <div>
                <h3 class="text-xs font-bold uppercase tracking-widest text-amber-500 mb-4">About Us</h3>
                <p class="text-sm text-coffee-300 leading-relaxed max-w-sm">
                    Simeon Brewers Coffee serves premium coffee crafted with precision in Silago, Southern Leyte.
                </p>
            </div>

            <div>
                <h3 class="text-xs font-bold uppercase tracking-widest text-amber-500 mb-4">Contact</h3>
                <ul class="space-y-3 text-sm text-coffee-300">
                    <li class="flex items-center gap-2.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-amber-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        <span>09771053180</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-amber-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                        <a href="mailto:hersanofritz@gmail.com" class="hover:text-white transition-colors duration-200">hersanofritz@gmail.com</a>
                    </li>
                </ul>
            </div>

            <div>
                <h3 class="text-xs font-bold uppercase tracking-widest text-amber-500 mb-4">Hours</h3>
                <ul class="space-y-2.5 text-sm text-coffee-300">
                    <li class="flex justify-between max-w-xs">
                        <span>Mon-Sat:</span>
                        <span class="text-white font-medium">9:00 AM - 5:00 PM</span>
                    </li>
                    <li class="flex justify-between max-w-xs text-zinc-600">
                        <span>Sunday:</span>
                        <span class="font-medium">Closed</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="pt-8 border-t border-coffee-800/40 text-center text-xs text-zinc-600 tracking-wide">
            &copy; 2026 Simeon Brewers Coffee. All rights reserved.
        </div>
    </div>
</footer>

</body>
</html>