<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Struk Pembayaran')</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            /* max-width: 600px; */
            margin: auto;
            /* padding: 20px; */
            /* border: 1px solid #ccc; */
        }

        h2,
        h4 {
            text-align: center;
            margin: 0;
        }

        .section {
            margin-top: 20px;
        }

        .section strong {
            display: block;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .section table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .section td {
            padding: 4px 0;
            vertical-align: top;
        }

        .section td:first-child {
            width: 35%;
        }

        .section td:nth-child(2) {
            width: 5%;
            text-align: center;
        }

        .section td:last-child {
            width: 50%;
        }

        .footer {
            margin-top: 60px;
            font-size: 14px;
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }
    </style>

    @stack('styles')
</head>

<body>
    @yield('content')
</body>

</html>
