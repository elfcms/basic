@extends('basic::admin.layouts.basic')

@section('pagecontent')

<div class="big-container">

    <nav class="pagenav">
        <ul>
            <li>
                <a href="{{ route('admin.page.pages') }}" class="button button-left">{{ __('basic::elf.pages') }}</a>
                <a href="{{ route('admin.page.pages.create') }}" class="button button-right">+</a>
            </li>
        </ul>
    </nav>
    @section('pagepage-content')
    @show

</div>
@endsection
