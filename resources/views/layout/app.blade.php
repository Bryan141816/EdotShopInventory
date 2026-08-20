<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex flex-row w-full h-screen">
    <x-nav />
    <main class="flex flex-col p-8 w-full">
        @yield('content')
    </main>

    @stack('scripts')
</body>

</html>
