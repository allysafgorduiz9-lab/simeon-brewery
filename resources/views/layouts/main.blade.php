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

    <!-- Navigation -->
    <nav class="bg-coffee-900 text-white p-4 sticky top-0 z-50 shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/" class="text-2xl font-extrabold tracking-widest text-coffee-300 hover:text-white transition">Simeon Brewers</a>
            <div class="hidden md:flex gap-6 text-base font-medium items-center">
                <a href="/" class="hover:text-yellow-500 transition">Home</a>
                <a href="/menu" class="hover:text-yellow-500 transition">Menu</a>
                <a href="/about" class="hover:text-yellow-500 transition">About</a>
                <a href="/admin" title="Staff Login" class="text-gray-400 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </a>
                @php
    $storeStatus = session('store_status', 'open');
@endphp

@if($storeStatus == 'open')
    <a href="/cart"
       class="bg-yellow-600 hover:bg-yellow-700 px-5 py-2 rounded font-bold transition">
       Cart 🛒
    </a>
@else
    <button
       class="bg-gray-500 cursor-not-allowed px-5 py-2 rounded font-bold text-white">
       Store Closed
    </button>
@endif
            </div>
        </div>
    </nav>
    @php
    $storeStatus = session('store_status', 'open');
@endphp

@if($storeStatus == 'closed')
<div class="bg-red-600 text-white text-center py-4 shadow-lg">
    <h2 class="text-2xl font-bold">🚫 STORE IS CURRENTLY CLOSED</h2>
    <p class="text-sm mt-1">
        Ordering is temporarily unavailable. Please come back later.
    </p>
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
                
                <!-- About Us -->
                <div>
                    <h3 class="text-xl font-bold text-white mb-4">About Us</h3>
                    <p class="text-sm text-coffee-300 leading-relaxed">
                        Simeon Brewers Coffee is located in Poblacion District 1, Silago, Southern Leyte. 
                        We serve premium roasted coffee with a cozy atmosphere perfect for hanging out with friends. 
                        Come and taste our famous brews near SJAP Plaza!
                    </p>
                </div>

                <!-- Contact Info -->
                <div>
                    <h3 class="text-xl font-bold text-white mb-4">Contact Us</h3>
                    <ul class="space-y-3 text-sm text-coffee-300">
                        <li class="flex items-center gap-2">
                            <span>📞</span>
                            <a href="tel:09771053180" class="hover:text-white transition">09771053180</a>
                        </li>
                        <li class="flex items-center gap-2">
                            <span>📧</span>
                            <a href="mailto:hersanofritz@gmail.com" class="hover:text-white transition">hersanofritz@gmail.com</a>
                        </li>
                        <li class="flex items-start gap-2">
                            <span>📍</span>
                            <span>Poblacion District 1, Silago, Southern Leyte<br>(Near SJAP Plaza)</span>
                        </li>
                    </ul>
                </div>

                <!-- Store Hours & Links -->
                <div>
                    <h3 class="text-xl font-bold text-white mb-4">Store Hours</h3>
                    <ul class="text-sm text-coffee-300 mb-6">
                        <li class="flex justify-between">
                            <span>Monday - Saturday</span>
                            <span class="text-white font-bold">9:00 AM - 5:00 PM</span>
                        </li>
                        <li class="flex justify-between text-gray-500">
                            <span>Sunday</span>
                            <span>Closed</span>
                        </li>
                    </ul>

                    <!-- Quick Links -->
                    <div class="flex gap-3">
                        <a href="https://www.google.com/maps/@10.5279751,125.1622679,3a,75y,273.99h,80.8t/data=!3m7!1e1!3m5!1s8KR80UNwyyqw0sMd43_8xA!2e0!6shttps:%2F%2Fstreetviewpixels-pa.googleapis.com%2Fv1%2Fthumbnail%3Fcb_client%3Dmaps_sv.tactile%26w%3D900%26h%3D600%26pitch%3D9.196145765483152%26panoid%3D8KR80UNwyyqw0sMd43_8xA%26yaw%3D273.98595850580534!7i16384!8i8192?entry=ttu&g_ep=EgoyMDI2MDUxMy4wIKXMDSoASAFQAw%3D%3D" 
                           target="_blank"
                           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm font-bold transition">
                           📍 Map
                        </a>
                        <a href="https://www.facebook.com/profile.php?id=100092630560572" 
                           target="_blank"
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-bold transition">
                           📘 Facebook
                        </a>
                    </div>
                </div>

            </div>

            <!-- Bottom Bar -->
            <div class="border-t border-coffee-800 mt-10 pt-6 text-center text-sm text-gray-500">
                <p>&copy; 2024 Simeon Brewers Coffee. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>