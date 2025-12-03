<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
    </style>
    @yield('styles')
</head>
<body class="bg-white">
    <!-- Header -->
    @include('layouts.header')

    <!-- Sidebar Navigation -->
    @include('layouts.navbar')

    <!-- Main Content Area -->
    <main class="pt-16 pl-0 md:pl-[60px] bg-white min-h-screen">
        @yield('content')
    </main>

    <!-- Mobile Bottom Padding -->
    <div class="pb-6 md:pb-0"></div>
</body>
</html>
