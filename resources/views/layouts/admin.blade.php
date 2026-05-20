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
                        coffee: { 100: '#f5f5dc', 700: '#6f4e37', 800: '#3b2f2f', 900: '#231a1a' }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Segoe UI', sans-serif; }
    </style>
</head>
<body class="bg-gray-100">

    <div class="flex h-screen">
        
        <!-- Sidebar -->
        <div class="w-64 bg-coffee-900 text-white flex flex-col">
            <!-- Logo -->
            <div class="p-6 text-center border-b border-coffee-800">
                <div class="text-3xl mb-1">☕</div>
                <h1 class="text-lg font-bold">Simeon Brewers</h1>
                <p class="text-xs text-gray-400">Admin Panel</p>
            </div>

            <!-- Menu -->
            <nav class="flex-1 p-4 space-y-2">
                <a href="/admin/dashboard" class="block px-4 py-3 rounded hover:bg-coffee-800 transition {{ request()->is('admin*') ? 'bg-coffee-700' : '' }}">
                    📊 Dashboard
                </a>
                <a href="/admin/orders" class="block px-4 py-3 rounded hover:bg-coffee-800 transition">
                    📋 Active Orders
                </a>
                <a href="/admin/products" class="block px-4 py-3 rounded hover:bg-coffee-800 transition">
                    ☕ Manage Menu
                </a>
                <a href="/admin/categories" class="block px-4 py-3 rounded hover:bg-coffee-800 transition">
                    📂 Categories
                </a>
                <a href="/admin/reports" class="block px-4 py-3 rounded hover:bg-coffee-800 transition">
                    📈 Reports
                </a>
                <a href="/admin/feedbacks" class="block px-4 py-3 rounded hover:bg-coffee-800 transition">
                    💬 Feedbacks
                </a>
            </nav>

            <!-- Logout -->
            <div class="p-4 border-t border-coffee-800">
                <a href="/" class="block text-center px-4 py-2 rounded bg-coffee-800 hover:bg-coffee-700 transition">
                    🚪 Back to Website
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-y-auto">
            <!-- Top Header -->
            <header class="bg-white p-4 shadow flex justify-between items-center">
                <h2 class="text-xl font-bold text-coffee-900">Admin Panel</h2>
                
                <!-- Store Status Toggle -->
<form action="/toggle-store" method="POST">
    @csrf
    <button type="submit" class="px-6 py-2 rounded-full font-bold text-white 
        {{ env('STORE_STATUS') == 'open' ? 'bg-green-500' : 'bg-red-500' }}">
        Store: {{ env('STORE_STATUS') == 'open' ? 'OPEN' : 'CLOSED' }}
    </button>
</form>
            </header>

            <!-- Page Content -->
            <main class="p-8">
                @yield('content')
            </main>
        </div>
    </div>

</body>
</html>