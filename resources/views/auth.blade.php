<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ? "$title - " . config('app.name') : config('app.name') }}</title>

    @vite('resources/css/app.css')
    @livewireStyles
    @stack('styles')
</head>

<body>
    {{ $slot }}
    @livewireScripts
</body>

</html>
