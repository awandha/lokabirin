<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lokabirin</title>

    @vite('resources/css/app.css')
    @livewireStyles
    @laravelPWA
</head>
<body class="min-h-full flex flex-col text-gray-800">
    <main class="flex-1 max-w-7xl mx-auto w-full p-6">
        @yield('content')
    </main>

    @vite('resources/js/app.js')
    @livewireScripts

    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function () {
                navigator.serviceWorker.register('/serviceworker.js').then(
                    function (registration) {
                        console.log('✅ Service Worker registered with scope:', registration.scope);
                    },
                    function (err) {
                        console.log('❌ Service Worker registration failed:', err);
                    }
                );
            });
        }
    </script>
</body>
</html>
