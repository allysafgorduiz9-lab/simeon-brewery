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
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
    </style>
</head>

<body class="bg-coffee-100 text-coffee-800 flex flex-col min-h-screen antialiased selection:bg-coffee-700 selection:text-white">

@php
    $setting = \App\Models\Setting::first();
    $storeStatus = optional($setting)->store_status ?? 'open';
@endphp

@if($storeStatus == 'closed')
    <div class="bg-gradient-to-r from-rose-900 to-rose-950 text-rose-200 border-b border-rose-800 text-center py-3 px-4 font-medium text-sm tracking-wide shadow-inner flex items-center justify-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-rose-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/></svg>
        Store is CLOSED — Ordering is currently unavailable
    </div>
@else
    <div class="bg-gradient-to-r from-emerald-900 to-emerald-950 text-emerald-200 border-b border-emerald-800 text-center py-3 px-4 font-medium text-sm tracking-wide shadow-inner flex items-center justify-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-emerald-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        Store is OPEN — You can place your order now
    </div>
@endif

<nav class="bg-coffee-900/95 text-white sticky top-0 z-50 shadow-md backdrop-blur-md border-b border-coffee-800/40">
    <div class="container mx-auto px-6 h-20 flex justify-between items-center">

        <a href="/" class="flex items-center gap-3 group">
            <img src="{{ asset('Simeon Cafe.jpg') }}" alt="Simeon Cafe" class="w-10 h-10 rounded-full object-cover border-2 border-amber-500 shadow-md transition-transform duration-300 group-hover:scale-105" onerror="this.src='https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=100&auto=format&fit=crop&q=60'">
            <span class="text-xl md:text-2xl font-black tracking-wider text-white">
                <span class="text-amber-500">Simeon</span> Brewers
            </span>
        </a>

        <div class="flex items-center gap-6 text-sm font-semibold tracking-wide">
            <div class="hidden sm:flex items-center gap-6">
                <a href="/" class="text-amber-400 border-b-2 border-amber-500 py-1">Home</a>
                <a href="/menu" class="text-gray-300 hover:text-amber-400 transition-colors duration-200 py-1">Menu</a>
                <a href="/about" class="text-gray-300 hover:text-amber-400 transition-colors duration-200 py-1">About</a>
                <a href="/admin" class="text-gray-400 hover:text-white transition-colors duration-200 py-1">Admin</a>
            </div>

            <span class="hidden sm:inline h-4 w-px bg-coffee-800"></span>

            @if($storeStatus == 'open')
                <div class="flex items-center gap-3">
                    <a href="/menu"
                       class="bg-emerald-600 hover:bg-emerald-500 text-white px-4 py-2.5 rounded-lg font-bold transition-all duration-200 shadow-sm hover:shadow active:scale-95 text-xs md:text-sm">
                        Order Now
                    </a>

                    <a href="/cart"
                       class="bg-amber-600 hover:bg-amber-500 text-white px-4 py-2.5 rounded-lg font-bold transition-all duration-200 shadow-sm hover:shadow active:scale-95 flex items-center gap-2 text-xs md:text-sm">
                        Cart
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
                    </a>
                </div>
            @else
                <button disabled
                        class="bg-zinc-800 px-4 py-2.5 rounded-lg font-bold text-zinc-400 cursor-not-allowed text-xs md:text-sm border border-zinc-700/60 shadow-inner">
                    Orders Closed
                </button>
            @endif
        </div>
    </div>
</nav>

<header class="relative bg-cover bg-center bg-no-repeat text-center py-24 md:py-32 border-b border-coffee-800/20 shadow-inner"
        style="background-image: linear-gradient(rgba(20, 12, 4, 0.75), rgba(20, 12, 4, 0.85)), url('https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?q=80&w=2070&auto=format&fit=crop');">
    <div class="container mx-auto px-6 max-w-4xl">
        <h1 class="text-4xl md:text-6xl font-black text-white tracking-tight mb-4 drop-shadow-md">
            Simeon Brewers
        </h1>
        <p class="text-amber-200 text-lg md:text-xl font-medium max-w-xl mx-auto tracking-wide drop-shadow-sm">
            Premium roasted coffee for the perfect morning.
        </p>
    </div>
</header>

<main class="flex-grow bg-coffee-100">
    @yield('content')
</main>

<footer class="bg-coffee-900 text-gray-400 py-16 border-t border-coffee-800/40 mt-auto">
    <div class="container mx-auto px-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-12">

        <div>
            <h3 class="text-xs font-bold uppercase tracking-widest text-amber-500 mb-4">About Us</h3>
            <p class="text-sm text-coffee-300 leading-relaxed">
                Simeon Brewers Coffee serves premium handcrafted coffee crafted with precision in Silago, Southern Leyte.
            </p>
        </div>

        <div>
            <h3 class="text-xs font-bold uppercase tracking-widest text-amber-500 mb-4">Navigation</h3>
            <ul class="space-y-2.5 text-sm">
                <li><a href="/" class="text-coffee-300 hover:text-amber-400 transition-colors duration-150 flex items-center gap-1.5"><span>›</span> Home</a></li>
                <li><a href="/menu" class="text-coffee-300 hover:text-amber-400 transition-colors duration-150 flex items-center gap-1.5"><span>›</span> Menu</a></li>
                <li><a href="/about" class="text-coffee-300 hover:text-amber-400 transition-colors duration-150 flex items-center gap-1.5"><span>›</span> About Us</a></li>
            </ul>
        </div>

        <div>
            <h3 class="text-xs font-bold uppercase tracking-widest text-amber-500 mb-4">Contact Channels</h3>
            <ul class="space-y-4 text-sm text-coffee-300">
                <li class="flex items-center gap-2.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-amber-600 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    <span>09771053180</span>
                </li>
                <li class="flex items-center gap-2.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-amber-600 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                    <a href="mailto:hersanofritz@gmail.com" class="hover:text-white transition-colors duration-200 break-all">hersanofritz@gmail.com</a>
                </li>
                <li class="pt-1">
                    <a href="https://www.facebook.com/profile.php?id=100092630560572" 
                       target="_blank" 
                       class="inline-flex items-center gap-2 bg-[#1877F2]/10 hover:bg-[#1877F2]/20 border border-[#1877F2]/30 text-[#1877F2] px-3.5 py-2 rounded-lg font-bold text-xs transition-all duration-200 active:scale-95 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        Find Us on Facebook
                    </a>
                </li>
            </ul>
        </div>

        <div>
            <h3 class="text-xs font-bold uppercase tracking-widest text-amber-500 mb-3">Hours & Location</h3>
            <div class="text-sm text-coffee-300 space-y-4">
                <div>
                    <span class="block text-xs font-bold uppercase tracking-wider text-zinc-500 mb-0.5">Store Hours</span>
                    <p class="text-white font-medium">Mon - Sat: 9:00 AM - 5:00 PM</p>
                    <p class="text-zinc-600 text-xs mt-0.5">Sunday: Closed</p>
                </div>
                
                <div>
                    <span class="block text-xs font-bold uppercase tracking-wider text-zinc-500 mb-0.5">Address</span>
                    <p class="leading-relaxed">Poblacion District 1, Silago, Southern Leyte</p>
                    <p class="text-amber-400/80 text-xs italic font-medium mt-1">📍 Front of SJAP Plaza</p>
                </div>

                <div class="pt-1">
                    <a href="https://www.google.com/maps/@10.5279751,125.1622679,3a,75y,288.09h,79.85t/data=!3m7!1e1!3m5!1s8KR80UNwyyqw0sMd43_8xA!2e0!6shttps:%2F%2Fstreetviewpixels-pa.googleapis.com%2Fv1%2Fthumbnail%3Fcb_client%3Dmaps_sv.tactile%26w%3D900%26h%3D600%26pitch%3D10.150000000000006%26panoid%3D8KR80UNwyyqw0sMd43_8xA%26yaw%3D288.09!7i16384!8i8192?entry=ttu&g_ep=EgoyMDI2MDUxMy4wIKXMDSoASAFQAw%3D%3D"
                       target="_blank"
                       class="inline-flex items-center gap-2 bg-blue-600/10 hover:bg-blue-600/20 border border-blue-500/30 text-blue-400 px-3.5 py-2.5 rounded-lg font-bold text-xs transition-all duration-200 active:scale-95 shadow-sm w-full justify-center sm:w-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                        View on Google Maps
                    </a>
                </div>
            </div>
        </div>

    </div>

    <div class="text-center text-xs text-zinc-600 mt-14 border-t border-coffee-800/40 pt-6 tracking-wide">
        &copy; 2026 Simeon Brewers Coffee. All rights reserved.
    </div>
</footer>

</body>
</html>