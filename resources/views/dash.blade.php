<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? config('app.name') }}</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')
</head>

<body>
    @livewire('layout.sidebar')

    @livewireScripts
    @stack('scripts')
</body>

</html>
