<!DOCTYPE html>
<html lang="en">
<head>
    @section('head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $page['title'] ?? $site_settings['title'] }}</title>
    @isset($site_settings['icon'])
    <link rel="shortcut icon" href="{{ asset($site_settings['icon']) }}" type="image/x-icon">
    @endisset
    @isset($site_settings['keywords'])
    <meta name="keywords" content="{{ $site_settings['keywords'] }}">
    @endisset
    @isset($site_settings['description'])
    <meta name="description" content="{{ $site_settings['description'] }}">
    @endisset
    <link rel="stylesheet" href="/storage/fonts/water-brush.css">
    <link rel="stylesheet" href="/storage/fonts/raleway.css">
    <link rel="stylesheet" href="/storage/fonts/roboto.css">
    <link rel="stylesheet" href="/css/style.css">
    @show
</head>
<body>
    @section('header')
    <header class="header">
        {{-- <div class="header-top">
            <x-menu.cupatea.top menu="4" />
        </div>
        <div class="header-box">
            <a href="/" class="header-title">{{ $site_settings['title'] }}</a>
            <div class="header-subtitle">{{ $site_settings['slogan'] }}</div>
        </div> --}}
    </header>
    @show

    <main class="main">
        <div class="main-content-box">
    @section('main')
    @show

    </main>

    @section('footer')
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-navigation">
                <nav>
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li><a href="/blog">Blog</a></li>
                        <li><a href="/about">About</a></li>
                    </ul>
                </nav>
                {{-- <nav>
                    <ul>
                        <li><h5>Categories</h5></li>
                        <li><a href="#">Have tea alone</a></li>
                        <li><a href="#">In a good company</a></li>
                    </ul>
                </nav> --}}
                <div class="society-box">
                    <ul>
                        <li><a href="" class="facebook"></a></li>
                        <li><a href="" class="instagram"></a></li>
                        <li><a href="" class="twitter"></a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-copyright">
                &copy; 2022 Maxim Klassen
            </div>
        </div>
    </footer>
    @show
</body>
</html>
