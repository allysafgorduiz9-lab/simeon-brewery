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
                            100: '#fcfbfa', // Bright, clean, premium light background
                            200: '#f3ece3', // Soft warm cream accent
                            300: '#d9c3b0', // Earthy secondary text / borders
                            700: '#523a28', // Deep roast accent
                            800: '#2c1d11', // Very deep roast 
                            900: '#1c120c'  // Ultra dark base
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body { font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif; }
    </style>
</head>

<body class="bg-coffee-100 text-coffee-800 antialiased selection:bg-coffee-700 selection:text-white">

@php
    $setting = \App\Models\Setting::first();
    $storeStatus = optional($setting)->store_status ?? 'open';
@endphp

<!-- NAVIGATION -->
<nav class="bg-coffee-900 text-white sticky top-0 z-50 shadow-md backdrop-blur-md bg-opacity-95 border-b border-coffee-800">
    <div class="container mx-auto px-6 h-20 flex justify-between items-center">

        <a href="/" class="text-xl md:text-2xl font-black tracking-wider text-white hover:text-amber-400 transition-colors duration-300 flex items-center gap-2">
            <span class="text-amber-500">Simeon</span> Brewers
        </a>

        <div class="hidden md:flex gap-8 text-sm font-semibold items-center tracking-wide">
            <a href="/" class="text-gray-300 hover:text-amber-400 transition-colors duration-200 py-2">Home</a>
            <a href="/menu" class="text-gray-300 hover:text-amber-400 transition-colors duration-200 py-2">Menu</a>
            <a href="/about" class="text-gray-300 hover:text-amber-400 transition-colors duration-200 py-2">About</a>

            <span class="h-4 w-px bg-coffee-800"></span>

            <a href="/admin" class="text-gray-400 hover:text-white transition-colors duration-200 p-2 rounded-lg hover:bg-coffee-800/50" title="Staff Login">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </a>

            <!-- CART / ORDER BUTTON -->
            @if($storeStatus == 'open')
                <a href="/cart"
                   class="bg-amber-600 hover:bg-amber-500 text-white px-5 py-2.5 rounded-lg font-bold transition-all duration-200 shadow-sm hover:shadow active:scale-95 flex items-center gap-2">
                     Cart 
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
                </a>
            @else
                <button disabled
                        class="bg-zinc-700 px-5 py-2.5 rounded-lg font-bold text-zinc-400 cursor-not-allowed flex items-center gap-2 border border-zinc-600">
                    Store Closed
                </button>
            @endif
        </div>
    </div>
</nav>

<!-- STORE STATUS BANNER -->
@if($storeStatus == 'closed')
    <div class="bg-rose-900 border-b border-rose-800 text-rose-100 text-center py-3.5 px-4 font-medium text-sm tracking-wide shadow-inner flex items-center justify-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-rose-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/></svg>
        Ordering is currently closed. Please come back later!
    </div>
@endif

<!-- MAIN CONTENT -->
<main class="min-h-screen">
    @yield('content')
</main>

<!-- FOOTER -->
<footer class="bg-coffee-900 text-gray-400 py-16 border-t border-coffee-800">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-12">
            <div>
                <h3 class="text-sm font-bold uppercase tracking-widest text-white mb-4">About Us</h3>
                <p class="text-sm text-coffee-300 leading-relaxed max-w-sm">
                    Simeon Brewers Coffee serves premium coffee crafted with precision in Silago, Southern Leyte.
                </p>
            </div>

            <div>
                <h3 class="text-sm font-bold uppercase tracking-widest text-white mb-4">Contact</h3>
                <ul class="space-y-3 text-sm text-coffee-300">
                    <li class="flex items-center gap-2.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        <span>09771053180</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                        <a href="mailto:hersanofritz@gmail.com" class="hover:text-white transition-colors duration-200">hersanofritz@gmail.com</a>
                    </li>
                </ul>
            </div>

            <div>
                <h3 class="text-sm font-bold uppercase tracking-widest text-white mb-4">Hours</h3>
                <ul class="space-y-2.5 text-sm text-coffee-300">
                    <li class="flex justify-between max-w-xs">
                        <span>Mon-Sat:</span>
                        <span class="text-white font-medium">9:00 AM - 5:00 PM</span>
                    </li>
                    <li class="flex justify-between max-w-xs text-zinc-500">
                        <span>Sunday:</span>
                        <span class="font-medium">Closed</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="pt-8 border-t border-coffee-800/60 text-center text-xs text-zinc-600 tracking-wide">
            &copy; 2026 Simeon Brewers Coffee. All rights reserved.
        </div>
    </div>
</footer>

</body>
</html>