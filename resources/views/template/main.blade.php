<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body class="d-flex flex-column min-vh-100">
    @include('template.header')
    <div class="my-3 flex-grow-1 container">
        @yield('content')
    </div>
    @include('template.footer')
</body>

</html>
