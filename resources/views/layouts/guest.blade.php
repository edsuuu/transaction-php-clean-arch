<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts._head')
<body class="min-h-screen flex items-center justify-center p-4" style="background: radial-gradient(ellipse at top left, #2d0a4e 0%, #1a0533 50%, #0d0020 100%);">
    {{ $slot }}

    @livewireScripts
</body>
</html>
