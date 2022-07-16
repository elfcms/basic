@extends('basic::admin.layouts.form')

@section('formpage-content')

    @if (Session::has('formedited'))
        <div class="alert alert-success">{{ Session::get('formedited') }}</div>
    @endif
    @if (Session::has('formcreated  '))
        <div class="alert alert-success">{{ Session::get('formcreated') }}</div>
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
        <h3>{{ __('basic::elf.edit_form') }}</h3>
        <form action="{{ route('admin.form.forms.update',$form->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="colored-rows-box">
                <div class="input-box colored">
                    <label for="title">{{ __('basic::elf.title') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="title" id="title" autocomplete="off" value="{{ $form->title }}">
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="code">{{ __('basic::elf.code') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="code" id="code" autocomplete="off" data-isslug value="{{ $form->code }}">
                    </div>
                    <div class="input-wrapper">
                        <div class="autoslug-wrapper">
                            <input type="checkbox" data-text-id="title" data-slug-id="code" data-slug-space="_" class="autoslug" >
                            <div class="autoslug-button"></div>
                        </div>
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="name">{{ __('basic::elf.name') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="name" id="name" autocomplete="off" data-isslug value="{{ $form->name }}">
                    </div>
                    <div class="input-wrapper">
                        <div class="autoslug-wrapper">
                            <input type="checkbox" data-text-id="title" data-slug-id="name" class="autoslug" >
                            <div class="autoslug-button"></div>
                        </div>
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="action">{{ __('basic::elf.action') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="action" id="action" autocomplete="off" value="{{ $form->action }}">
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="enctype">{{ __('basic::elf.enctype') }}</label>
                    <div class="input-wrapper">
                        <select name="enctype" id="enctype">
                            <option value="">None</option>
                        @foreach ($enctypes as $enctype)
                            <option value="{{$enctype}}" @if ($form->enctype==$enctype) selected @endif>{{$enctype}}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="description">{{ __('basic::elf.description') }}</label>
                    <div class="input-wrapper">
                        <textarea name="description" id="description" cols="30" rows="3">{{ $form->description }}</textarea>
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="redirect_to">{{ __('basic::elf.redirect_to') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="redirect_to" id="redirect_to" autocomplete="off" value="{{ $form->redirect_to }}">
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="submit_button">{{ __('basic::elf.submit_button') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="submit_button" id="submit_button" autocomplete="off" value="{{ $form->submit_button }}">
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="submit_name">{{ __('basic::elf.submit_name') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="submit_name" id="submit_name" autocomplete="off" value="{{ $form->submit_name }}">
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="submit_title">{{ __('basic::elf.submit_title') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="submit_title" id="submit_title" autocomplete="off" value="{{ $form->submit_title }}">
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="submit_value">{{ __('basic::elf.submit_value') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="submit_value" id="submit_value" autocomplete="off" value="{{ $form->submit_value }}">
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="reset_button">{{ __('basic::elf.reset_button') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="reset_button" id="reset_button" autocomplete="off" value="{{ $form->reset_button }}">
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="reset_title">{{ __('basic::elf.reset_title') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="reset_title" id="reset_title" autocomplete="off" value="{{ $form->reset_title }}">
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="reset_value">{{ __('basic::elf.reset_value') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="reset_value" id="reset_value" autocomplete="off" value="{{ $form->reset_value }}">
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
