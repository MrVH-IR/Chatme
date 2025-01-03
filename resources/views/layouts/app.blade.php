<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    @yield('head')
</head>
<header>
    @yield('header')
    <nav>
        @yield('nav')
    </nav>
</header>

<body>
    <main>
        @yield('main')
    </main>
    @yield('body')
    <footer>
        @yield('footer')
    </footer>
</body>

</html>
