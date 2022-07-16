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
        <h3>{{ __('basic::elf.edit_email_event') }} #{{ $event->id }}</h3>
        <form action="{{ route('admin.email.events.update',$event->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="colored-rows-box">
                <div class="input-box colored">
                    <label for="code">{{ __('basic::elf.code') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="code" id="code" autocomplete="off" value="{{ $event->code }}">
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="name">{{ __('basic::elf.name') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="name" id="name" autocomplete="off" value="{{ $event->name }}">
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="subject">{{ __('basic::elf.subject') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="subject" id="subject" autocomplete="off" value="{{ $event->subject }}">
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="description">{{ __('basic::elf.description') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="description" id="description" autocomplete="off" value="{{ $event->description }}">
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="content">{{ __('basic::elf.content') }}</label>
                    <div class="input-wrapper">
                        <textarea type="text" name="content" id="content" cols="30" rows="6">{{ $event->content }}</textarea>
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
                                @forelse ($params as $param => $value)
                                <div class="params-table-string-line" data-line="{{ $loop->index }}">
                                    <div class="params-table-string">
                                        <input type="text" name="params_new[{{ $loop->index }}][name]" id="param_new_name_{{ $loop->index }}" value="{{$param}}" data-param-name>
                                    </div>
                                    <div class="params-table-string">
                                        <input type="text" name="params_new[{{ $loop->index }}][value]" id="param_new_value_{{ $loop->index }}" value="{{$value}}" data-param-value>
                                    </div>
                                    <div class="params-table-string">
                                        <button type="button" class="default-btn" onclick="eventParamDelete({{ $loop->index }})">&#215;</button>
                                    </div>
                                </div>
                                @empty
                                <div class="params-table-string-line" data-line="0">
                                    <div class="params-table-string">
                                        <input type="text" name="params_new[0][name]" id="param_new_name_0" data-param-name>
                                    </div>
                                    <div class="params-table-string">
                                        <input type="text" name="params_new[0][value]" id="param_new_value_0" data-param-value>
                                    </div>
                                    <div class="params-table-string">
                                        <button type="button" class="default-btn" onclick="eventParamDelete(0)">&#215;</button>
                                    </div>
                                </div>
                                @endforelse


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
            @foreach ($event->emailFields as $fieldName)
                <div class="input-box colored">
                    <label for="{{ $fieldName }}" class="capitalize">{{ $fieldName }}</label>
                    <div class="input-wrapper">
                        {{-- <input type="text" name="{{ $fieldName }}" id="{{ $fieldName }}" autocomplete="off" value="@if(!empty($fields[$fieldName])) {{$fields[$fieldName]}} @endif"> --}}
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
        eventParamBoxInit('#addparamline', {{count($params)-1}})
    </script>

@endsection
