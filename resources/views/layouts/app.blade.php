<!DOCTYPE html>
<html lang="en">
<head>    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lokabirin</title>
    @vite('resources/css/app.css')    
    @livewireStyles
    @laravelPWA
</head>
<body>
    <div class="container mx-auto p-4">
        @yield('content')
    </div>
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
