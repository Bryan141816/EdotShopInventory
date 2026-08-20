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
  <body class="bg-gray-100 justify-center items-center flex h-screen">
    <main class="bg-white p-8 rounded shadow-md w-full max-w-md">
      @yield('content')
    </main>
  </body>
</html>
