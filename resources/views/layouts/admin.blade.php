<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Simeon Brewers</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        coffee: {
                            100: '#faf8f5',
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
            font-family: 'Segoe UI', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100">

@php
    $setting = \App\Models\Setting::first();
    $storeStatus = optional($setting)->store_status ?? 'open';
@endphp

<div class="flex min-h-screen">

    <aside class="w-72 bg-coffee-900 text-white flex flex-col shadow-2xl">

        <div class="p-6 border-b border-coffee-800">
            <div class="flex items-center gap-4">
                <img src="{{ asset('Simeon Cafe.jpg') }}"
                     class="w-14 h-14 rounded-full border-2 border-amber-500 object-cover">

                <div>
                    <h1 class="text-xl font-bold">
                        Simeon Cafe
                    </h1>

                    <p class="text-amber-500 text-sm tracking-widest font-semibold">
                        ADMIN PANEL
                    </p>
                </div>
            </div>
        </div>

        <nav class="flex-1 p-5 space-y-3">

            <a href="/admin/dashboard"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition
               {{ request()->is('admin/dashboard') ? 'bg-coffee-700 shadow-lg' : 'hover:bg-coffee-800' }}">

                📊 <span>Dashboard</span>
            </a>

            <a href="/admin/orders"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition
               {{ request()->is('admin/orders') ? 'bg-coffee-700 shadow-lg' : 'hover:bg-coffee-800' }}">

                📋 <span>Active Orders</span>
            </a>

            <a href="/admin/products"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition
               {{ request()->is('admin/products') ? 'bg-coffee-700 shadow-lg' : 'hover:bg-coffee-800' }}">

                ☕ <span>Manage Menu</span>
            </a>

            <a href="/admin/categories"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition
               {{ request()->is('admin/categories') ? 'bg-coffee-700 shadow-lg' : 'hover:bg-coffee-800' }}">

                📂 <span>Categories</span>
            </a>

            <a href="/admin/reports"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition
               {{ request()->is('admin/reports') ? 'bg-coffee-700 shadow-lg' : 'hover:bg-coffee-800' }}">

                📈 <span>Reports</span>
            </a>

            <div class="border-t border-coffee-800 pt-3 mt-3">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" 
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-xl transition hover:bg-red-900 text-left">
                        🚪 <span>Logout</span>
                    </button>
                </form>
            </div>

        </nav>

        <div class="p-5 border-t border-coffee-800">

            <a href="/"
               class="block text-center bg-coffee-800 hover:bg-coffee-700 py-3 rounded-xl font-semibold transition">

                🚪 Back to Website

            </a>

        </div>

    </aside>

    <div class="flex-1 flex flex-col">

        <header class="bg-white shadow-sm border-b px-8 py-5 flex justify-between items-center">

            <div>
                <h2 class="text-2xl font-bold text-coffee-900">
                    Admin Dashboard
                </h2>

                <p class="text-sm text-gray-500">
                    Welcome back, Administrator
                </p>
            </div>

            <form action="/admin/store-toggle" method="POST">
                @csrf

                <button type="submit"
                    class="relative inline-flex items-center w-32 h-12 rounded-full transition-all duration-300 shadow-lg
                    {{ $storeStatus == 'open' ? 'bg-green-500' : 'bg-red-500' }}">

                    <span class="absolute left-1 top-1 bg-white w-10 h-10 rounded-full shadow-md transition-all duration-300
                    {{ $storeStatus == 'open' ? 'translate-x-20' : '' }}">
                    </span>

                    <span class="w-full text-center text-white font-bold z-10 tracking-wide">
                        {{ strtoupper($storeStatus) }}
                    </span>

                </button>
            </form>

        </header>

        <main class="flex-1 p-8 overflow-y-auto">
            @yield('content')
        </main>

    </div>

</div>

</body>
</html>