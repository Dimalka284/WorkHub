<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Site - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

    <x-navbar/>

    {{-- Main content placeholder --}}
    <main class="py-8 px-4">
        @yield('content')
    </main>

    <x-footer />

</body>
</html>
