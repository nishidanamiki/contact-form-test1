<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contact Form</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alegreya:ital,wght@0,400..900;1,400..900&display=swap"
        rel="stylesheet">
    @yield('css')
</head>

<body>
    @if (!View::hasSection('no_header'))
        <header class="header">
            <h1>FashionablyLate</h1>
            @hasSection('show_nav')
                <nav class="header__nav">
                    @if (Auth::check())
                    @endif
                    @yield('show_nav')
                </nav>
            @endif
        </header>
    @endif
    <main>
        @yield('content')
    </main>
    <footer>
    </footer>
</body>

</html>
