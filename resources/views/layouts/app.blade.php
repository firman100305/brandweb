<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Thream 3AM — Clothing for the quiet hours')</title>
    <meta name="description" content="@yield('description', 'Thream (3AM) is a black-and-white clothing brand made for the hours when the city has gone quiet.')">
    <link rel="icon" type="image/png" href="{{ asset('logo/logo1.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @include('partials.sidebar')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    @stack('modals')
</body>
</html>
