<!DOCTYPE html>
<html lang="en">
<head>    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lokabirin</title>
    @vite('resources/css/app.css')    
    @livewireStyles
</head>
<body>
    <div class="container mx-auto p-4">
        @yield('content')
    </div>
    @vite('resources/js/app.js')
    @livewireScripts
</body>
</html>
