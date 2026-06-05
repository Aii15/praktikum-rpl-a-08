<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SpotRent')</title>

    <!-- Google Fonts Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Global Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    
    <!-- Page Specific Stylesheets -->
    @yield('styles')
</head>
<body>

    @yield('content')

    <!-- Page Specific Scripts -->
    @yield('scripts')
</body>
</html>
