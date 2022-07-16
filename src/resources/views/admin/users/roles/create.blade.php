@extends('basic::admin.layouts.users')

@section('userpage-content')

@if ($errors->any())
<div class="alert alert-danger">
    <h4>{{ __('basic::elf.errors') }}</h4>
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="user-form item-form">
    <h3>{{ __('basic::elf.create_new_role') }}</h3>
    <form action="{{ route('admin.users.roles.store') }}" method="POST">
        @csrf
        <div class="colored-rows-box">
            <div class="input-box colored">
                <label for="name">{{ __('basic::elf.name') }}</label>
                <div class="input-wrapper">
                    <input type="text" name="name" id="name" autocomplete="off">
                </div>
            </div>
            <div class="input-box colored">
                <label for="code">{{ __('basic::elf.code') }}</label>
                <div class="input-wrapper">
                    <input type="text" name="code" id="code" autocomplete="off">
                </div>
            </div>
            <div class="input-box colored">
                <label for="description">{{ __('basic::elf.description') }}</label>
                <div class="input-wrapper">
                    <input type="text" name="description" id="description" autocomplete="off">
                </div>
            </div>

        </div>

        <div class="button-box single-box">
            <button type="submit" class="default-btn submit-button">{{ __('basic::elf.submit') }}</button>
        </div>
    </form>
</div>
@endsection
