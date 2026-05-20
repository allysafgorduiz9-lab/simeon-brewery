<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Simeon Brewers</title>
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
        body {
            background: linear-gradient(135deg, #3b2f2f 0%, #231a1a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>

    <!-- Login Box -->
    <div class="bg-white rounded-xl shadow-2xl overflow-hidden max-w-md w-full">
        <!-- Header -->
        <div class="bg-coffee-900 text-center py-8 px-6">
            <div class="text-4xl mb-2">☕</div>
            <h1 class="text-2xl font-bold text-white">Simeon Brewers</h1>
            <p class="text-coffee-300 text-sm">Staff Administration</p>
        </div>

        <!-- Form -->
        <div class="p-8">
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.dashboard') }}" method="POST">
        @csrf
        
        <div class="mb-6">
            <label class="block text-sm font-bold text-gray-700 mb-2">Username</label>
            <input type="text" name="username" placeholder="admin" 
                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-coffee-700 focus:border-transparent transition">
        </div>

        <div class="mb-6">
            <label class="block text-sm font-bold text-gray-700 mb-2">Password</label>
            <input type="password" name="password" placeholder="simeon123" 
                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-coffee-700 focus:border-transparent transition">
        </div>

        <button type="submit" class="w-full bg-coffee-800 hover:bg-coffee-900 text-white font-bold py-3 rounded-lg transition transform hover:scale-105 shadow-lg">
            Login
        </button>
    </form>

    <div class="mt-6 text-center">
        <a href="/" class="text-sm text-coffee-700 hover:text-coffee-900 underline">
            ← Back to Website
        </a>
    </div>
</div>

</body>
</html>