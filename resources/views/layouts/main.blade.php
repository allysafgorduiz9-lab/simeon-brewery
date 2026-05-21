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
                        coffee: { 100: '#f5f5dc', 200: '#e8e4c9', 300: '#d2b48c', 700: '#6f4e37', 800: '#3b2f2f', 900: '#231a1a' }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    </style>
</head>

<body class="bg-coffee-100 text-gray-800">

@php
    $setting = \App\Models\Setting::first();
    $storeStatus = $setting ? $setting->store_status : 'open';
@endphp

<!-- Navigation -->
<nav class="bg-coffee-900 text-white p-4 sticky top-0 z-50 shadow-lg">
    <div class="container mx-auto flex justify-between items-center">

        <a href="/" class="text-2xl font-extrabold tracking-widest text-coffee-300 hover:text-white transition">
            Simeon Brewers
        </a>

        <div class="hidden md:flex gap-6 text-base font-medium items-center">

            <a href="/" class="hover:text-yellow-500 transition">Home</a>
            <a href="/menu" class="hover:text-yellow-500 transition">Menu</a>
            <a href="/about" class="hover:text-yellow-500 transition">About</a>

            <a href="/admin" title="Staff Login" class="text-gray-400 hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </a>

            <!-- Cart / Order Button -->
            @if($storeStatus == 'open')
                <a href="/cart"
                   class="bg-yellow-600 px-4 py-2 rounded font-bold hover:bg-yellow-700 transition">
                    Cart 🛒
                </a>
            @else
                <button disabled
                        class="bg-gray-500 px-4 py-2 rounded cursor-not-allowed text-white">
                    Store Closed
                </button>
            @endif

        </div>
    </div>
</nav>

<!-- Store Closed Banner -->
@if($storeStatus == 'closed')
    <div class="bg-red-600 text-white text-center py-3 font-bold">
        🚫 Ordering is currently closed. Please come back later.
    </div>
@endif

<!-- Main Content -->
<main class="min-h-screen">
    @yield('content')
</main>

<!-- Footer -->
<footer class="bg-coffee-900 text-coffee-100 py-12 border-t-4 border-yellow-700">
    <div class="container mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <div>
                <h3 class="text-xl font-bold text-white mb-4">About Us</h3>
                <p class="text-sm text-coffee-300 leading-relaxed">
                    Simeon Brewers Coffee is located in Poblacion District 1, Silago, Southern Leyte.
                </p>
            </div>

            <div>
                <h3 class="text-xl font-bold text-white mb-4">Contact Us</h3>
                <ul class="space-y-3 text-sm text-coffee-300">
                    <li>📞 09771053180</li>
                    <li>📧 hersanofritz@gmail.com</li>
                </ul>
            </div>

            <div>
                <h3 class="text-xl font-bold text-white mb-4">Store Hours</h3>
                <p class="text-sm text-coffee-300">Mon-Sat: 9AM - 5PM</p>
                <p class="text-sm text-gray-500">Sunday: Closed</p>
            </div>

        </div>

        <div class="border-t border-coffee-800 mt-10 pt-6 text-center text-sm text-gray-500">
            <p>&copy; 2024 Simeon Brewers Coffee. All rights reserved.</p>
        </div>
    </div>
</footer>

</body>
</html>