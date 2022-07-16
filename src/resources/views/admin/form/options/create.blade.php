@extends('basic::admin.layouts.form')

@section('formpage-content')

    @if (Session::has('formedited'))
        <div class="alert alert-success">{{ Session::get('formedited') }}</div>
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
        <h3>{{ __('basic::elf.create_form') }}</h3>
        <form action="{{ route('admin.form.forms.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="colored-rows-box">
                <div class="input-box colored">
                    <label for="title">{{ __('basic::elf.title') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="title" id="title" autocomplete="off">
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="code">{{ __('basic::elf.code') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="code" id="code" autocomplete="off" data-isslug>
                    </div>
                    <div class="input-wrapper">
                        <div class="autoslug-wrapper">
                            <input type="checkbox" data-text-id="title" data-slug-id="code" data-slug-space="_" class="autoslug" checked>
                            <div class="autoslug-button"></div>
                        </div>
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="name">{{ __('basic::elf.name') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="name" id="name" autocomplete="off" data-isslug>
                    </div>
                    <div class="input-wrapper">
                        <div class="autoslug-wrapper">
                            <input type="checkbox" data-text-id="title" data-slug-id="name" class="autoslug" checked>
                            <div class="autoslug-button"></div>
                        </div>
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="description">{{ __('basic::elf.description') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="description" id="description" autocomplete="off">
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="submit_button">{{ __('basic::elf.submit_button') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="submit_button" id="submit_button" autocomplete="off">
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="submit_name">{{ __('basic::elf.submit_name') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="submit_name" id="submit_name" autocomplete="off">
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="submit_title">{{ __('basic::elf.submit_title') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="submit_title" id="submit_title" autocomplete="off">
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="submit_value">{{ __('basic::elf.submit_value') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="submit_value" id="submit_value" autocomplete="off">
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="reset_button">{{ __('basic::elf.reset_button') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="reset_button" id="reset_button" autocomplete="off">
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="reset_title">{{ __('basic::elf.reset_title') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="reset_title" id="reset_title" autocomplete="off">
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="reset_value">{{ __('basic::elf.reset_value') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="reset_value" id="reset_value" autocomplete="off">
                    </div>
                </div>
            </div>
            <div class="button-box single-box">
                <button type="submit" class="default-btn submit-button">{{ __('basic::elf.submit') }}</button>
            </div>
        </form>
    </div>
    <script>
    autoSlug('.autoslug')
    inputSlugInit()
    </script>

@endsection
