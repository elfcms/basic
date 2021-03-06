@extends('basic::admin.layouts.menu')

@section('menupage-content')

    @if (Session::has('menuedited'))
        <div class="alert alert-success">{{ Session::get('menuedited') }}</div>
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
        <h3>{{ __('basic::elf.create_menu_item') }}</h3>
        <form action="{{ route('admin.menu.items.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="colored-rows-box">
                <div class="input-box colored">
                    <label for="menu_id">{{ __('basic::elf.menu') }}</label>
                    <div class="input-wrapper">
                        <select name="menu_id" id="menu_id">
                        @foreach ($menus as $menu)
                            <option value="{{ $menu->id }}" @if($menu_id == $menu->id) selected @endif>{{ $menu->name }}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="parent_id">{{ __('basic::elf.parent_item') }}</label>
                    <div class="input-wrapper">
                        <select name="parent_id" id="parent_id">
                            <option value="" data-menu="0">None</option>
                        @foreach ($items as $item)
                            <option value="{{ $item->id }}" @if($parent_id == $item->id) selected @endif data-menu="{{ $item->menu_id }}" @if ($item->menu_id != $menu_id) style="display:none" @endif>{{ $item->text }}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="text">{{ __('basic::elf.text') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="text" id="text" autocomplete="off">
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="link">{{ __('basic::elf.link') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="link" id="link" autocomplete="off">
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="title">{{ __('basic::elf.title') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="title" id="title" autocomplete="off">
                    </div>
                </div>
                <div class="input-box colored">
                    <div class="checkbox-wrapper">
                        <div class="checkbox-inner">
                            <input
                                type="checkbox"
                                name="clickable"
                                id="clickable"
                                checked
                            >
                            <i></i>
                            <label for="clickable">
                                {{ __('basic::elf.item_is_clickable') }}
                            </label>
                        </div>
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="handler">{{ __('basic::elf.handler') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="handler" id="handler" autocomplete="off">
                    </div>
                </div>
                <div class="input-box colored" id="attributesbox">
                    <label for="">{{ __('basic::elf.attributes') }}</label>
                    <div class="input-wrapper">
                        <div>
                            <div class="input-attributes-table">
                                <div class="attributes-table-head-line">
                                    <div class="attributes-table-head">
                                        {{ __('basic::elf.name') }}
                                    </div>
                                    <div class="attributes-table-head">
                                        {{ __('basic::elf.value') }}
                                    </div>
                                    <div class="attributes-table-head"></div>
                                </div>
                                <div class="attributes-table-string-line" data-line="0">
                                    <div class="attributes-table-string">
                                        <input type="text" name="attributes_new[0][name]" id="attribute_new_name_0" data-attribute-name>
                                    </div>
                                    <div class="attributes-table-string">
                                        <input type="text" name="attributes_new[0][value]" id="attribute_new_value_0" data-attribute-value>
                                    </div>
                                    <div class="attributes-table-string">
                                        {{-- <button type="button" class="default-btn" onclick="menuAttrDelete(0)">&#215;</button> --}}
                                    </div>
                                </div>

                            </div>
                            <button type="button" class="default-btn attribute-table-add" id="addattributeline">{{ __('basic::elf.add_attribute') }}</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="button-box single-box">
                <button type="submit" class="default-btn submit-button">{{ __('basic::elf.submit') }}</button>
            </div>
        </form>
    </div>
    <script>
        menuAttrBoxInit('#addattributeline')
        selectFilter('#menu_id','#parent_id','data-menu','0')
    </script>


@endsection
