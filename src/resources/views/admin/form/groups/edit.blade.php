@extends('basic::admin.layouts.form')

@section('formpage-content')

    @if (Session::has('groupedited'))
        <div class="alert alert-success">{{ Session::get('groupedited') }}</div>
    @endif
    @if (Session::has('groupcreated  '))
        <div class="alert alert-success">{{ Session::get('groupcreated') }}</div>
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
        <h3>{{ __('basic::elf.edit_form_field_group') }}</h3>
        <form action="{{ route('admin.form.groups.update',$group->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="colored-rows-box">
                <div class="input-box colored">
                    <label for="form_id">{{ __('basic::elf.form') }}</label>
                    <div class="input-wrapper">
                        <select name="form_id" id="form_id">
                            @foreach ($forms as $item)
                                <option value="{{ $item->id }}" @if ($item->id == $group->form_id) selected @endif>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="title">{{ __('basic::elf.title') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="title" id="title" autocomplete="off" value="{{ $group->title }}">
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="code">{{ __('basic::elf.code') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="code" id="code" autocomplete="off" data-isslug value="{{ $group->code }}">
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
                        <input type="text" name="name" id="name" autocomplete="off" data-isslug value="{{ $group->name }}">
                    </div>
                    <div class="input-wrapper">
                        <div class="autoslug-wrapper">
                            <input type="checkbox" data-text-id="title" data-slug-id="name" class="autoslug" >
                            <div class="autoslug-button"></div>
                        </div>
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="description">{{ __('basic::elf.description') }}</label>
                    <div class="input-wrapper">
                        <textarea name="description" id="description" cols="30" rows="3">{{ $group->description }}</textarea>
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="position">{{ __('basic::elf.position') }}</label>
                    <div class="input-wrapper">
                        <input type="number" name="position" id="position" autocomplete="off" value="{{ $group->position }}">
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
