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
            <li @if(Str::startsWith(Route::currentRouteName(),'admin.users')) class="active" @endif>
                <a href="{{ route('admin.users') }}">
                    <img src="/vendor/elfcms/basic/admin/images/icons/users.png" alt="">
                    <span>Users</span>
                </a>
                <ul class="submenu">
                    <li @if(Str::startsWith(Route::currentRouteName(),'admin.users') && !Str::startsWith(Route::currentRouteName(),'admin.users.roles')) class="active" @endif>
                        <a href="{{ route('admin.users') }}">Users</a>
                    </li>
                    <li @if(Str::startsWith(Route::currentRouteName(),'admin.users.roles')) class="active" @endif>
                        <a href="{{ route('admin.users.roles') }}">Roles</a>
                    </li>
                </ul>
            </li>
            <li @if(Route::is('admin.settings.index')) class="active" @endif>
                <a href="{{ route('admin.settings.index') }}">
                    <img src="/vendor/elfcms/basic/admin/images/icons/settings.png" alt="">
                    <span>Settings</span>
                </a>
            </li>
            <li @if(Str::startsWith(Route::currentRouteName(),'admin.email')) class="active" @endif>
                <a href="{{ route('admin.email') }}">
                    <img src="/vendor/elfcms/basic/admin/images/icons/email.png" alt="">
                    <span>Email</span>
                </a>
                <ul class="submenu">
                    <li @if(Str::startsWith(Route::currentRouteName(),'admin.email.addresses')) class="active" @endif>
                        <a href="{{ route('admin.email.addresses') }}">Addresses</a>
                    </li>
                </ul>
                <ul class="submenu">
                    <li @if(Str::startsWith(Route::currentRouteName(),'admin.email.events')) class="active" @endif>
                        <a href="{{ route('admin.email.events') }}">Events</a>
                    </li>
                </ul>
            </li>
            {{-- <li @if(Str::startsWith(Route::currentRouteName(),'admin.form')) class="active" @endif>
                <a href="{{ route('admin.form') }}">
                    <img src="/vendor/elfcms/basic/admin/images/icons/forms.png" alt="">
                    <span>{{ __('basic::elf.form') }}</span>
                </a>
                <ul class="submenu">
                    <li @if(Str::startsWith(Route::currentRouteName(),'admin.form.forms')) class="active" @endif>
                        <a href="{{ route('admin.form.forms') }}">{{ __('basic::elf.forms') }}</a>
                    </li>
                    <li @if(Str::startsWith(Route::currentRouteName(),'admin.form.groups')) class="active" @endif>
                        <a href="{{ route('admin.form.groups') }}">{{ __('basic::elf.field_groups') }}</a>
                    </li>
                    <li @if(Str::startsWith(Route::currentRouteName(),'admin.form.fields')) class="active" @endif>
                        <a href="{{ route('admin.form.fields') }}">{{ __('basic::elf.fields') }}</a>
                    </li>
                </ul>
            </li>
            <li @if(Str::startsWith(Route::currentRouteName(),'admin.blog')) class="active" @endif>
                <a href="{{ route('admin.blog') }}">
                    <img src="/vendor/elfcms/basic/admin/images/icons/blog.png" alt="">
                    <span>Blog</span>
                </a>
                <ul class="submenu">
                    <li @if(Str::startsWith(Route::currentRouteName(),'admin.blog.categories')) class="active" @endif>
                        <a href="{{ route('admin.blog.categories') }}">Categories</a>
                    </li>
                    <li @if(Str::startsWith(Route::currentRouteName(),'admin.blog.posts')) class="active" @endif>
                        <a href="{{ route('admin.blog.posts') }}">Posts</a>
                    </li>
                    <li @if(Str::startsWith(Route::currentRouteName(),'admin.blog.tags')) class="active" @endif>
                        <a href="{{ route('admin.blog.tags') }}">Tags</a>
                    </li>
                    <li @if(Str::startsWith(Route::currentRouteName(),'admin.blog.comments')) class="active" @endif>
                        <a href="{{ route('admin.blog.comments') }}">Comments</a>
                    </li>
                    <li @if(Str::startsWith(Route::currentRouteName(),'admin.blog.votes')) class="active" @endif>
                        <a href="{{ route('admin.blog.votes') }}">Votes</a>
                    </li>
                    <li @if(Str::startsWith(Route::currentRouteName(),'admin.blog.likes')) class="active" @endif>
                        <a href="{{ route('admin.blog.likes') }}">Likes</a>
                    </li>
                </ul>
            </li>
            <li @if(Str::startsWith(Route::currentRouteName(),'admin.menu')) class="active" @endif>
                <a href="{{ route('admin.menu.menus') }}">
                    <img src="/vendor/elfcms/basic/admin/images/icons/menu.png" alt="">
                    <span>Menu</span>
                </a>
                <ul class="submenu">
                    <li @if(Str::startsWith(Route::currentRouteName(),'admin.menu.menus')) class="active" @endif>
                        <a href="{{ route('admin.menu.menus') }}">Menus</a>
                    </li>
                </ul>
                <ul class="submenu">
                    <li @if(Str::startsWith(Route::currentRouteName(),'admin.menu.items')) class="active" @endif>
                        <a href="{{ route('admin.menu.items') }}">Items</a>
                    </li>
                </ul>
            </li>
            <li @if(Str::startsWith(Route::currentRouteName(),'admin.page.pages')) class="active" @endif>
                <a href="{{ route('admin.page.pages') }}">
                    <img src="/vendor/elfcms/basic/admin/images/icons/pages.png" alt="">
                    <span>Pages</span>
                </a>
            </li> --}}
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
