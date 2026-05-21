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
                            100: '#faf8f5',
                            200: '#f1e6da',
                            300: '#d4bda7',
                            700: '#4a3319',
                            800: '#2b1a08',
                            900: '#140c04'
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

<body class="bg-coffee-100 text-coffee-800 flex flex-col min-h-screen">

@php
    $setting = \App\Models\Setting::first();
    $storeStatus = optional($setting)->store_status ?? 'open';
@endphp

<!-- STORE STATUS BANNER -->
@if($storeStatus == 'closed')
    <div class="bg-red-600 text-white text-center py-2 font-bold">
        🚫 Store is CLOSED — Ordering is currently unavailable
    </div>
@else
    <div class="bg-green-600 text-white text-center py-2 font-bold">
        🟢 Store is OPEN — You can place your order now
    </div>
@endif

<!-- NAVBAR -->
<nav class="bg-coffee-900 text-white sticky top-0 z-50 shadow-md">
    <div class="container mx-auto px-6 h-20 flex justify-between items-center">

        <!-- LOGO -->
        <a href="/" class="text-xl font-black">
            <span class="text-amber-500">Simeon</span> Brewers
        </a>

        <!-- LINKS -->
        <div class="flex items-center gap-6 text-sm font-semibold">

            <a href="/" class="text-gray-300 hover:text-amber-400">Home</a>
            <a href="/menu" class="text-gray-300 hover:text-amber-400">Menu</a>
            <a href="/about" class="text-gray-300 hover:text-amber-400">About</a>
            <a href="/admin" class="text-gray-400 hover:text-white">Admin</a>

            <!-- ORDER SYSTEM -->
            @if($storeStatus == 'open')
                <a href="/menu"
                   class="bg-green-600 hover:bg-green-500 text-white px-5 py-2 rounded-lg font-bold transition shadow">
                    Order Now
                </a>

                <a href="/cart"
                   class="bg-amber-600 hover:bg-amber-500 text-white px-5 py-2 rounded-lg font-bold transition shadow">
                    Cart 🛒
                </a>
            @else
                <button disabled
                        class="bg-gray-700 text-gray-400 px-5 py-2 rounded-lg cursor-not-allowed">
                    Orders Closed
                </button>
            @endif

        </div>
    </div>
</nav>

<!-- PAGE CONTENT -->
<main class="flex-grow bg-coffee-100">
    @yield('content')
</main>

<!-- FOOTER -->
<footer class="bg-coffee-900 text-gray-400 py-14 mt-auto">

    <div class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-10">

        <!-- ABOUT -->
        <div>
            <h3 class="text-amber-500 font-bold mb-3">About Us</h3>
            <p class="text-sm leading-relaxed">
                Simeon Brewers Coffee serves premium handcrafted coffee in Silago, Southern Leyte.
            </p>
        </div>

        <!-- CONTACT -->
        <div>
            <h3 class="text-amber-500 font-bold mb-3">Contact</h3>
            <p>📞 09771053180</p>
            <p>📧 hersanofritz@gmail.com</p>
        </div>

        <!-- LOCATION -->
        <div>
            <h3 class="text-amber-500 font-bold mb-3">Location</h3>

            <p class="text-sm mb-4">
                Poblacion District 1, Silago, Southern Leyte
            </p>

            <a href="https://www.google.com/maps/@10.5279751,125.1622679,3a,75y,288.09h,79.85t/data=!3m7!1e1!3m5!1s8KR80UNwyyqw0sMd43_8xA!2e0!6shttps:%2F%2Fstreetviewpixels-pa.googleapis.com%2Fv1%2Fthumbnail%3Fcb_client%3Dmaps_sv.tactile%26w%3D900%26h%3D600%26pitch%3D10.150000000000006%26panoid%3D8KR80UNwyyqw0sMd43_8xA%26yaw%3D288.09!7i16384!8i8192?entry=ttu&g_ep=EgoyMDI2MDUxMy4wIKXMDSoASAFQAw%3D%3D"
               target="_blank"
               class="inline-block bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-lg font-bold transition shadow">
                📍 View on Google Maps
            </a>
        </div>

    </div>

    <div class="text-center text-xs text-gray-600 mt-10 border-t border-gray-800 pt-6">
        © 2026 Simeon Brewers Coffee. All rights reserved.
    </div>

</footer>

</body>
</html>