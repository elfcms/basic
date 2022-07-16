@extends('basic::admin.layouts.users')

@section('userpage-content')

@if (Session::has('roleedited'))
    <div class="alert alert-success">{{ Session::get('roleedited') }}</div>
@endif
@if (Session::has('rolecreated'))
    <div class="alert alert-success">{{ Session::get('rolecreated') }}</div>
@endif
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
    <h3>{{ __('basic::elf.edit_role') }} #{{ $role->id }}</h3>
    <form action="{{ route('admin.users.roles.update',$role->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="colored-rows-box">
            <div class="input-box colored">
                <label for="name">{{ __('basic::elf.name') }}</label>
                <div class="input-wrapper">
                    <input type="text" name="name" id="name" autocomplete="off" value="{{ $role->name }}">
                </div>
            </div>
            <div class="input-box colored">
                <label for="code">{{ __('basic::elf.code') }}</label>
                <div class="input-wrapper">
                    <input type="text" name="code" id="code" autocomplete="off" value="{{ $role->code }}">
                </div>
            </div>
            <div class="input-box colored">
                <label for="description">{{ __('basic::elf.description') }}</label>
                <div class="input-wrapper">
                    <input type="text" name="description" id="description" autocomplete="off" value="{{ $role->description }}">
                </div>
            </div>

        </div>

        <div class="button-box single-box">
            <button type="submit" class="default-btn submit-button">{{ __('basic::elf.submit') }}</button>
        </div>
    </form>
</div>
@endsection
