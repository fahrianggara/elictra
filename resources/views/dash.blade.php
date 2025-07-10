<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ? "$title - " . config('app.name') : config('app.name') }}</title>

    <link rel="stylesheet" href="{{ asset('css/coreui.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js', 'public/css/custom.css', 'public/js/custom.js'])
    @livewireStyles
    @stack('styles')
</head>

<body class="bg-gray-100">
    @livewire('layout.dash.sidebar')

    <div class="wrapper d-flex flex-column min-vh-100">

        @livewire('layout.dash.header')

        <div class="body flex-grow-1 d-flex flex-column">
            <div class="container-fluid pl-[270px] pr-[15px] py-[15px]">
                {{ $slot }}
            </div>

        </div>

        @livewire('layout.dash.footer')
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@coreui/coreui@5.1.2/dist/js/coreui.min.js"
        integrity="sha384-kiD3MgQ2eSqSjSfkoKS7/ipCvMvkfmpWHk3WRppeqnYxCVF0wQ+7gHzkXfJyvHbQ" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.all.min.js"></script>
    <script src="{{ asset('js/custom.js') }}"></script>

    @livewireScripts

    <script>
        Livewire.on('toast', (e) => {
            const fireOptions = {
                icon: e.icon || 'success',
                title: e.title || e.message || '',
                ...e.fireOptions, // if using nested fireOptions
            };

            const mixinOptions = e.mixinOptions || {};
            toast(fireOptions, mixinOptions);
        });
    </script>

    @stack('scripts')
</body>

</html>
