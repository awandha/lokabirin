<!-- resources/views/layouts/admin.blade.php -->
<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lokabirin Admin</title>

    @vite('resources/css/app.css')
    @livewireStyles
</head>
<body class="min-h-full flex flex-col text-gray-800">

    <!-- ✅ Admin Header -->
    <header class="bg-white shadow sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
            <h1 class="text-xl font-bold text-gray-900">
                Lokabirin Admin
            </h1>

            <!-- ✅ Mobile Burger -->
            <button id="admin-nav-toggle"
                    class="sm:hidden flex items-center px-3 py-2 border rounded text-gray-700 border-gray-400 hover:text-blue-600 hover:border-blue-600">
                <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                    <path d="M0 3h20v2H0zM0 9h20v2H0zM0 15h20v2H0z"/>
                </svg>
            </button>

            <!-- ✅ Nav + Profile -->
            <div class="hidden sm:flex items-center gap-6 text-sm" id="admin-nav-links">
                <a href="/admin/orders"
                class="{{ request()->is('admin/orders') ? 'text-blue-600 font-bold' : 'text-gray-700 hover:text-blue-600' }}">
                    Orders
                </a>
                <a href="/admin/tables"
                class="{{ request()->is('admin/tables') ? 'text-blue-600 font-bold' : 'text-gray-700 hover:text-blue-600' }}">
                    Tables
                </a>
                <a href="/admin/menu"
                class="{{ request()->is('admin/menu') ? 'text-blue-600 font-bold' : 'text-gray-700 hover:text-blue-600' }}">
                    Menu Items
                </a>
                <a href="/admin/reports"
                class="{{ request()->is('admin/reports') ? 'text-blue-600 font-bold' : 'text-gray-700 hover:text-blue-600' }}">
                    Reports
                </a>
                <a href="/kitchen"
                class="{{ request()->is('kitchen') ? 'text-blue-600 font-bold' : 'text-gray-700 hover:text-blue-600' }}">
                    Kitchen
                </a>

                <!-- ✅ Profile + Logout always shown on larger screens -->
                <a href="{{ route('profile.edit') }}"
                class="text-gray-700 hover:text-blue-600 transition">
                    Profile
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                            class="text-gray-700 hover:text-red-600 transition">
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- ✅ Mobile Links -->
        <div id="admin-mobile-menu" class="hidden sm:hidden px-4 pb-4">
            <nav class="flex flex-col gap-2 text-sm">
                <a href="/admin/orders"
                class="{{ request()->is('admin/orders') ? 'text-blue-600 font-bold' : 'text-gray-700 hover:text-blue-600' }}">
                    Orders
                </a>
                <a href="/admin/tables"
                class="{{ request()->is('admin/tables') ? 'text-blue-600 font-bold' : 'text-gray-700 hover:text-blue-600' }}">
                    Tables
                </a>
                <a href="/admin/menu"
                class="{{ request()->is('admin/menu') ? 'text-blue-600 font-bold' : 'text-gray-700 hover:text-blue-600' }}">
                    Menu Items
                </a>
                <a href="/admin/reports"
                class="{{ request()->is('admin/reports') ? 'text-blue-600 font-bold' : 'text-gray-700 hover:text-blue-600' }}">
                    Reports
                </a>
                <a href="/kitchen"
                class="{{ request()->is('kitchen') ? 'text-blue-600 font-bold' : 'text-gray-700 hover:text-blue-600' }}">
                    Kitchen
                </a>
                <a href="{{ route('profile.edit') }}"
                class="text-gray-700 hover:text-blue-600 transition">
                    Profile
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                            class="text-gray-700 hover:text-red-600 transition">
                        Logout
                    </button>
                </form>
            </nav>
        </div>
    </header>

    <main class="flex-1 max-w-7xl mx-auto w-full p-6">
        @yield('content')
    </main>

    <footer class="bg-white text-center text-xs text-gray-500 py-4 border-t">
        &copy; {{ date('Y') }} Lokabirin. All rights reserved.
    </footer>

    @vite('resources/js/app.js')
    @livewireScripts

    <script>
        const navToggle = document.getElementById('admin-nav-toggle');
        const mobileMenu = document.getElementById('admin-mobile-menu');

        navToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</body>
</html>
