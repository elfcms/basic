@extends('basic::admin.layouts.basic')

@section('pagecontent')

<div class="big-container">

    <nav class="pagenav">
        <ul>
            <li>
                <a href="{{ route('admin.form.forms') }}" class="button button-left">{{ __('basic::elf.forms') }}</a>
                <a href="{{ route('admin.form.forms.create') }}" class="button button-right">+</a>
            </li>
            <li>
                <a href="{{ route('admin.form.groups') }}" class="button button-left">{{ __('basic::elf.form_field_groups') }}</a>
                <a href="{{ route('admin.form.groups.create') }}" class="button button-right">+</a>
            </li>
            <li>
                <a href="{{ route('admin.form.fields') }}" class="button button-left">{{ __('basic::elf.form_fields') }}</a>
                <a href="{{ route('admin.form.fields.create') }}" class="button button-right">+</a>
            </li>
            {{--<li>
                <a href="{{ route('admin.form.options') }}" class="button button-left">{{ __('basic::elf.form_field_options') }}</a>
                <a href="{{ route('admin.form.options.create') }}" class="button button-right">+</a>
            </li>--}}
            {{--<li>
                <a href="{{ route('admin.form.field-types') }}" class="button">{{ __('basic::elf.form_field_types') }}</a>
            </li>--}}
        </ul>
    </nav>
    @section('formpage-content')
    @show

</div>
@endsection
