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
                            100: '#f5f5dc',
                            200: '#e8e4c9',
                            300: '#d2b48c',
                            700: '#6f4e37',
                            800: '#3b2f2f',
                            900: '#231a1a'
                        }
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
    $storeStatus = optional($setting)->store_status ?? 'open';
@endphp

<!-- NAVIGATION -->
<nav class="bg-coffee-900 text-white p-4 sticky top-0 z-50 shadow-lg">
    <div class="container mx-auto flex justify-between items-center">

        <a href="/" class="text-2xl font-extrabold tracking-widest text-coffee-300 hover:text-white transition">
            Simeon Brewers
        </a>

        <div class="hidden md:flex gap-6 text-base font-medium items-center">

            <a href="/" class="hover:text-yellow-500 transition">Home</a>
            <a href="/menu" class="hover:text-yellow-500 transition">Menu</a>
            <a href="/about" class="hover:text-yellow-500 transition">About</a>

            <a href="/admin" class="text-gray-400 hover:text-white" title="Staff Login">
                🔒
            </a>

            <!-- CART / ORDER BUTTON -->
            @if($storeStatus == 'open')
                <a href="/cart"
                   class="bg-yellow-600 hover:bg-yellow-700 px-5 py-2 rounded font-bold transition">
                    Cart 🛒
                </a>
            @else
                <button disabled
                        class="bg-gray-500 px-5 py-2 rounded cursor-not-allowed text-white">
                    Store Closed
                </button>
            @endif

        </div>
    </div>
</nav>

<!-- STORE STATUS BANNER -->
@if($storeStatus == 'closed')
    <div class="bg-red-600 text-white text-center py-3 font-bold">
        🚫 Ordering is currently closed. Please come back later.
    </div>
@endif

<!-- MAIN CONTENT -->
<main class="min-h-screen">
    @yield('content')
</main>

<!-- FOOTER -->
<footer class="bg-coffee-900 text-coffee-100 py-12 border-t-4 border-yellow-700">

    <div class="container mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">

        <div>
            <h3 class="text-xl font-bold text-white mb-4">About Us</h3>
            <p class="text-sm text-coffee-300">
                Simeon Brewers Coffee serves premium coffee in Silago, Southern Leyte.
            </p>
        </div>

        <div>
            <h3 class="text-xl font-bold text-white mb-4">Contact</h3>
            <p class="text-sm text-coffee-300">📞 09771053180</p>
            <p class="text-sm text-coffee-300">📧 hersanofritz@gmail.com</p>
        </div>

        <div>
            <h3 class="text-xl font-bold text-white mb-4">Hours</h3>
            <p class="text-sm text-coffee-300">Mon-Sat: 9AM - 5PM</p>
            <p class="text-sm text-gray-400">Sunday: Closed</p>
        </div>

    </div>

    <div class="text-center text-sm text-gray-500 mt-10">
        © 2024 Simeon Brewers Coffee
    </div>

</footer>

</body>
</html>