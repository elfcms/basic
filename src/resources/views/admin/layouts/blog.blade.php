@extends('basic::admin.layouts.basic')

@section('pagecontent')

<div class="big-container">

    <nav class="pagenav">
        <ul>
            <li>
                <a href="{{ route('admin.blog.categories') }}" class="button button-left">{{ __('basic::elf.categories') }}</a>
                <a href="{{ route('admin.blog.categories.create') }}" class="button button-right">+</a>
            </li>
            <li>
                <a href="{{ route('admin.blog.posts') }}" class="button button-left">{{ __('basic::elf.posts') }}</a>
                <a href="{{ route('admin.blog.posts.create') }}" class="button button-right">+</a>
            </li>
            <li>
                <a href="{{ route('admin.blog.tags') }}" class="button button-left">{{ __('basic::elf.tags') }}</a>
                <a href="{{ route('admin.blog.tags.create') }}" class="button button-right">+</a>
            </li>
            <li>
                <a href="{{ route('admin.blog.comments') }}" class="button">{{ __('basic::elf.comments') }}</a>
            </li>
            <li>
                <a href="{{ route('admin.blog.votes') }}" class="button">{{ __('basic::elf.votes') }}</a>
            </li>
            <li>
                <a href="{{ route('admin.blog.likes') }}" class="button">{{ __('basic::elf.likes') }}</a>
            </li>
        </ul>
    </nav>
    @section('blogpage-content')
    @show

</div>
@endsection
