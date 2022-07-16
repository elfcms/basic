@extends('basic::admin.layouts.basic')

@section('pagecontent')

<div class="big-container">
    @if (Session::has('settingedited'))
        <div class="alert alert-success">{{ Session::get('settingedited') }}</div>
    @endif
    @if (Session::has('settingcreated  '))
        <div class="alert alert-success">{{ Session::get('settingcreated') }}</div>
    @endif
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="errors-list">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="item-form">
        <h3>{{ __('basic::elf.edit_site_settings') }}</h3>
        <form action="{{ route('admin.settings.save') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="colored-rows-box">
            @foreach ($settings as $setting)
                @if (empty($setting['params']['type']) || $setting['params']['type'] == 'string')
                <div class="input-box colored">
                    <label for="{{ $setting['code'] }}">{{ $setting['name'] }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="{{ $setting['code'] }}" id="{{ $setting['code'] }}" autocomplete="off" value="{{ $setting['value'] }}">
                    </div>
                </div>
                @elseif ($setting['params']['type'] == 'text')
                <div class="input-box colored">
                    <label for="{{ $setting['code'] }}">{{ $setting['name'] }}</label>
                    <div class="input-wrapper">
                        <textarea name="{{ $setting['code'] }}" id="{{ $setting['code'] }}" cols="30" rows="3">{{ $setting['value'] }}</textarea>
                    </div>
                </div>
                @elseif ($setting['params']['type'] == 'image')
                <div class="input-box colored">
                    <label for="{{ $setting['code'] }}">{{ $setting['name'] }}</label>
                    <div class="input-wrapper">
                        <input type="hidden" name="{{ $setting['code'] }}_path" id="{{ $setting['code'] }}_path" value="{{$setting['value']}}">
                        <div class="image-button">
                            <div class="delete-image @if (empty($setting['value'])) hidden @endif">&#215;</div>
                            <div class="image-button-img">
                            @if (!empty($setting['value']))
                                <img src="{{ asset($setting['value']) }}" alt="">
                            @else
                                <img src="{{ asset('/vendor/elfcms/basic/admin/images/icons/upload.png') }}" alt="Upload file">
                            @endif
                            </div>
                            <div class="image-button-text">
                            @if (!empty($setting['value']))
                                {{ __('basic::elf.change_file') }}
                            @else
                                {{ __('basic::elf.choose_file') }}
                            @endif
                            </div>
                            <input type="file" name="{{ $setting['code'] }}" id="{{ $setting['code'] }}">
                        </div>
                    </div>
                </div>
                <script>
                    const {{ Str::camel($setting['code']) }} = document.querySelector('#{{ $setting['code'] }}')
                    if ({{ Str::camel($setting['code']) }}) {
                        inputFileImg({{ Str::camel($setting['code']) }})
                    }
                </script>
                @endif
            @endforeach
                {{-- <div class="input-box colored">
                    <label for="site_name">{{ __('basic::elf.site_name') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="site_name" id="site_name" autocomplete="off" value="{{ $settings->site_name }}">
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="site_title">{{ __('basic::elf.site_title') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="site_title" id="site_title" autocomplete="off" value="{{ $settings->site_title }}">
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="site_slogan">{{ __('basic::elf.site_slogan') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="site_slogan" id="site_slogan" autocomplete="off" value="{{ $settings->site_slogan }}">
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="site_logo">{{ __('basic::elf.site_logo') }}</label>
                    <div class="input-wrapper">
                        <input type="hidden" name="site_logo_path" id="site_logo_path" value="{{$settings->site_logo}}">
                        <div class="image-button">
                            <div class="delete-image @if (empty($settings->site_logo)) hidden @endif">&#215;</div>
                            <div class="image-button-img">
                            @if (!empty($settings->site_logo))
                                <img src="{{ asset($settings->site_logo) }}" alt="Site logo">
                            @else
                                <img src="{{ asset('/images/icons/upload.png') }}" alt="Upload file">
                            @endif
                            </div>
                            <div class="image-button-text">
                            @if (!empty($settings->site_logo))
                                {{ __('basic::elf.change_file') }}
                            @else
                                {{ __('basic::elf.choose_file') }}
                            @endif
                            </div>
                            <input type="file" name="site_logo" id="site_logo">
                        </div>
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="site_icon">{{ __('basic::elf.site_icon') }}</label>
                    <div class="input-wrapper">
                        <input type="hidden" name="site_icon_path" id="site_icon_path" value="{{$settings->site_icon}}">
                        <div class="image-button">
                            <div class="delete-image @if (empty($settings->site_icon)) hidden @endif">&#215;</div>
                            <div class="image-button-img">
                            @if (!empty($settings->site_icon))
                                <img src="{{ asset($settings->site_icon) }}" alt="Site icon">
                            @else
                                <img src="{{ asset('/images/icons/upload.png') }}" alt="Upload file">
                            @endif
                            </div>
                            <div class="image-button-text">
                            @if (!empty($settings->site_icon))
                                {{ __('basic::elf.change_file') }}
                            @else
                                {{ __('basic::elf.choose_file') }}
                            @endif
                            </div>
                            <input type="file" name="site_icon" id="site_icon">
                        </div>
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="site_keyword">{{ __('basic::elf.site_keyword') }}</label>
                    <div class="input-wrapper">
                        <textarea name="site_keyword" id="site_keyword" cols="30" rows="3">{{ $settings->site_keyword }}</textarea>
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="site_description">{{ __('basic::elf.site_description') }}</label>
                    <div class="input-wrapper">
                        <textarea name="site_description" id="site_description" cols="30" rows="3">{{ $settings->site_description }}</textarea>
                    </div>
                </div> --}}
            </div>
            <div class="button-box single-box">
                <button type="submit" class="default-btn submit-button">{{ __('basic::elf.submit') }}</button>
            </div>
        </form>
    </div>
</div>

@endsection
