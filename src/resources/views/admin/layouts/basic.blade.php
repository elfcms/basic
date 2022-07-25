<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $page['title'] }}</title>
    @isset($site_settings['icon'])
    <link rel="shortcut icon" href="{{ asset($site_settings['icon']) }}" type="image/x-icon">
    @endisset
    <link rel="stylesheet" href="{{ asset('vendor/elfcms/basic/admin/fonts/roboto/roboto.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/elfcms/basic/admin/css/style.css') }}">
    <script src="{{ asset('vendor/elfcms/basic/admin/js/elf.js') }}"></script>
</head>
<body>
@inject('currentUser', 'Elfcms\Basic\Elf\User')
@inject('menu', 'Elfcms\Basic\Elf\Admin\Menu')
<header id="header">
    <a href="/" class="logobox">
        <div class="logoimg">
            @isset($site_settings['logo'])
            <img src="{{ asset($site_settings['logo']) }}" alt="logo">
            @else

            @endisset
        </div>
        <div class="logoname">@isset($site_settings['name']) {{ $site_settings['name'] }} @endisset</div>
    </a>

    <nav id="mainmenu">
        <ul>
            @forelse ($menu::get() as $item)
            <li @if(Str::startsWith(Route::currentRouteName(),$item['parent_route'])) class="active" @endif>
                <a href="{{ route($item['route']) }}">
                    <img src="{{ $item['icon'] }}" alt="">
                    <span>@if (empty($item['lang_title']))
                    {{ $item['title'] }}
                    @else
                    {{ __($item['lang_title']) }}
                    @endif</span>
                </a>
                @if (!empty($item['submenu']))
                <ul class="submenu">
                    @foreach ($item['submenu'] as $subitem)
                    <li @if(Str::startsWith(Route::currentRouteName(),$subitem['route']) && (empty($item['submenu'][$loop->iteration]) || !Str::startsWith(Route::currentRouteName(),$item['submenu'][$loop->iteration]['route']))) class="active" @endif>
                        <a href="{{ route($subitem['route']) }}">
                            @if (empty($subitem['lang_title']))
                            {{ $subitem['title'] }}
                            @else
                            {{ __($subitem['lang_title']) }}
                            @endif
                        </a>
                    </li>
                    @endforeach
                </ul>
                @endif

            </li>
            @empty

            @endforelse

            <li class="only-mobile">
                <a href="/admin/logout">
                    <img src="/vendor/elfcms/basic/admin/images/icons/logout.png" alt="">
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </nav>
</header>
<main>
    <div id="toppanel">
        <div class="pageinfo">
            <div class="paginfo_title">
                <h1>{{ $page['title'] }}</h1>
            </div>
        </div>
        <div class="userinfo">
            {{$currentUser->user->name()}}
            {{-- <div class="userinfo_name">
                <a href="{{ route('admin.users.edit',['user'=>$currentUser->user->id]) }}">{{ $currentUser->name() }}</a>
            </div> --}}
            <div class="userinfo_avatar">
            {{-- @if (!empty($currentUser->avatar()))
                <img src="/{{ $currentUser->avatar(true) }}" alt="">
            @else
                <img src="/images/icons/users.png" alt="">
            @endif --}}
            </div>
            <nav class="userdata">
                <ul>
                    {{-- <li><a href="#">Params</a></li> --}}
                    <li><a href="/admin/logout">Logout</a></li>
                </ul>
            </nav>
        </div>
        <div class="menubutton closed"></div>
    </div>
    <div class="main-container">
        @section('pagecontent')

        @show

    </div>
</main>
<footer id="footer">

</footer>
<script src="{{ asset('vendor/elfcms/basic/admin/js/app.js') }}"></script>
</body>
</html>
