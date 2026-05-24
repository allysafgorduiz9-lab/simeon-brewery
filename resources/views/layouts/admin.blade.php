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
                        coffee: { 700: '#4a3319', 800: '#2b1a08', 900: '#140c04' }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100 font-sans">

@php
    $setting = \App\Models\Setting::first();
    $storeStatus = optional($setting)->store_status ?? 'open';
@endphp

<div class="flex min-h-screen">
    <aside class="w-72 bg-coffee-900 text-white flex flex-col shadow-2xl">
        <div class="p-6 border-b border-coffee-800">
            <div class="flex items-center gap-4">
                <img src="{{ asset('Simeon Cafe.jpg') }}" class="w-12 h-12 rounded-full border-2 border-amber-500 object-cover">
                <div>
                    <h1 class="text-lg font-bold">Simeon Cafe</h1>
                    <p class="text-amber-500 text-xs font-semibold tracking-wider uppercase">Admin Panel</p>
                </div>
            </div>
        </div>

        <nav class="flex-1 p-5 flex flex-col space-y-2">
            <a href="/admin/dashboard" class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->is('admin/dashboard') ? 'bg-coffee-700' : 'hover:bg-coffee-800' }}">📊 Dashboard</a>
            <a href="/admin/orders" class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->is('admin/orders') ? 'bg-coffee-700' : 'hover:bg-coffee-800' }}">📋 Active Orders</a>
            <a href="/admin/products" class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->is('admin/products') ? 'bg-coffee-700' : 'hover:bg-coffee-800' }}">☕ Manage Menu</a>
            <a href="/admin/categories" class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->is('admin/categories') ? 'bg-coffee-700' : 'hover:bg-coffee-800' }}">📂 Categories</a>
            <a href="/admin/reports" class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->is('admin/reports') ? 'bg-coffee-700' : 'hover:bg-coffee-800' }}">📈 Reports</a>
            
            <div class="mt-auto pt-6 border-t border-coffee-800">
                <a href="/admin/settings" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-coffee-800 transition mb-2">⚙️ Settings</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-red-900 transition text-left text-red-300">
                        🚪 Logout
                    </button>
                </form>
            </div>
        </nav>
    </aside>

    <div class="flex-1 flex flex-col">
        <header class="bg-white shadow-sm border-b px-8 py-4 flex justify-between items-center">
            <div>
                <h2 class="text-xl font-bold text-coffee-900">@yield('title', 'Admin Dashboard')</h2>
            </div>
            
            <form action="/admin/store-toggle" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-2 px-6 py-2 rounded-full font-bold text-sm shadow-md transition {{ $storeStatus == 'open' ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                    <span class="w-3 h-3 rounded-full bg-white"></span>
                    {{ strtoupper($storeStatus) }}
                </button>
            </form>
        </header>

        <main class="flex-1 p-8">
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>