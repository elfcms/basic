@extends('basic::admin.layouts.email')

@section('emailpage-content')

    @if (Session::has('eeventedited'))
        <div class="alert alert-success">{{ Session::get('eeventedited') }}</div>
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
        <h3>{{ __('basic::elf.create_email_event') }}</h3>
        <form action="{{ route('admin.email.events.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="colored-rows-box">
                <div class="input-box colored">
                    <label for="code">{{ __('basic::elf.code') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="code" id="code" autocomplete="off">
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="name">{{ __('basic::elf.name') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="name" id="name" autocomplete="off">
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="subject">{{ __('basic::elf.subject') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="subject" id="subject" autocomplete="off">
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="description">{{ __('basic::elf.description') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="description" id="description" autocomplete="off">
                    </div>
                </div>

                <div class="input-box colored">
                    <label for="content">{{ __('basic::elf.content') }}</label>
                    <div class="input-wrapper">
                        <textarea type="text" name="content" id="content" cols="30" rows="6"></textarea>
                    </div>
                </div>

                <div class="input-box colored" id="paramsbox">
                    <label for="">{{ __('basic::elf.parameters') }}</label>
                    <div class="input-wrapper">
                        <div>
                            <div class="input-params-table">
                                <div class="params-table-head-line">
                                    <div class="params-table-head">
                                        {{ __('basic::elf.name') }}
                                    </div>
                                    <div class="params-table-head">
                                        {{ __('basic::elf.value') }}
                                    </div>
                                    <div class="params-table-head"></div>
                                </div>
                                <div class="params-table-string-line" data-line="0">
                                    <div class="params-table-string">
                                        <input type="text" name="params_new[0][name]" id="param_new_name_0" data-param-name>
                                    </div>
                                    <div class="params-table-string">
                                        <input type="text" name="params_new[0][value]" id="param_new_value_0" data-param-value>
                                    </div>
                                    <div class="params-table-string">
                                        {{-- <button type="button" class="default-btn" onclick="eventParamDelete(0)">&#215;</button> --}}
                                    </div>
                                </div>

                            </div>
                            <button type="button" class="default-btn param-table-add" id="addparamline">{{ __('basic::elf.add_parameter') }}</button>
                        </div>
                    </div>
                </div>

            </div>
            <h4>Fields</h4>
            <div class="colored-rows-box">
            {{-- @foreach ($event->fields() as $fieldName => $field)
                <div class="input-box colored">
                    <label for="{{ $fieldName }}">{{ $fieldName }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="{{ $fieldName }}" id="{{ $fieldName }}" autocomplete="off" value="{{ $event->description }}">
                    </div>
                </div>
            @endforeach --}}
            @foreach ($fields as $fieldName)
                <div class="input-box colored">
                    <label for="{{ $fieldName }}" class="capitalize">{{ $fieldName }}</label>
                    <div class="input-wrapper">
                        <select name="{{ $fieldName }}" id="{{ $fieldName }}">
                            <option value="">None</option>
                        @foreach ($addresses as $address)
                            <option value="{{$address->id}}" @if (isset($fields[$fieldName]) && $fields[$fieldName]->email==$address->email) selected @endif>{{$address->name}} &lt;{{$address->email}}&gt;</option>
                        @endforeach
                        </select>
                    </div>
                </div>
            @endforeach

            </div>

            <div class="button-box single-box">
                <button type="submit" class="default-btn submit-button">{{ __('basic::elf.submit') }}</button>
            </div>
        </form>
    </div>
    <script>
        eventParamBoxInit('#addparamline')
    </script>

@endsection
