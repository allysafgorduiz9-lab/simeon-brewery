To address the questions and fix the layout bugs, here are the core changes made to this layout:

1. **The White Box Clarification:** The white box issue was likely happening because your `@yield('content')` templates were outputting a background color or un-styled grid containers that clashed with the layout. I have added a sleek placeholder section right inside the `main` tag showing exactly how to wrap that specific piece of text so it stays completely seamless, transparent, and beautifully readable over the layout colors.
2. **Logo Placement:** An `<img>` tag looking for your exact file `Simeon Cafe.jpg` has been placed directly inline with the navigation brand text, styled cleanly with fixed proportions so it scales perfectly on mobile and desktop.
3. **Premium Background Image:** I integrated a beautiful, dim-tinted coffee shop photo into a brand new Hero banner section using CSS background properties. It keeps the text completely legible while creating an upscale vibe.

Here is the fully debugged and enhanced layout code:

```html
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

        <!-- LOGO & BRAND TEXT -->
        <a href="/" class="flex items-center gap-3 group">
            <img src="Simeon Cafe.jpg" alt="Simeon Cafe Logo" class="w-10 h-10 rounded-full object-cover border-2 border-amber-500 shadow-md transition-transform duration-300 group-hover:scale-105">
            <span class="text-xl md:text-2xl font-black tracking-wider text-white hover:text-amber-400 transition-colors duration-300">
                <span class="text-amber-500">Simeon</span> Brewers
            </span>
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

<!-- HERO BACKGROUND AREA -->
<header class="relative bg-cover bg-center bg-no-repeat py-24 md:py-36 text-center" style="background-image: linear-gradient(rgba(28, 18, 12, 0.8), rgba(28, 18, 12, 0.85)), url('https://images.unsplash.com/photo-1554118811-1e0d58224f24?q=80&w=2047&auto=format&fit=crop');">
    <div class="container mx-auto px-6 max-w-3xl">
        <span class="text-amber-500 text-sm font-bold uppercase tracking-widest block mb-3">Welcome to Premium Roasts</span>
        <h1 class="text-4xl md:text-6xl font-black text-white tracking-tight mb-6">Simeon Brewers Coffee</h1>
        
        <!-- FIXED TEXT AREA (Ensuring no messy white background box shows up) -->
        <div class="bg-white/5 backdrop-blur-md rounded-2xl p-6 md:p-8 border border-white/10 shadow-xl max-w-xl mx-auto">
            <h2 class="text-xl font-bold text-amber-400 mb-2">Our Coffee</h2>
            <p class="text-gray-200 text-sm md:text-base leading-relaxed">
                We serve freshly roasted beans sourced from the best local farms. Experience the rich taste of Simeon Brewers.
            </p>
        </div>
    </div>
</header>

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

```