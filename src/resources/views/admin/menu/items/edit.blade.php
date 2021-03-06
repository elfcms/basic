@extends('basic::admin.layouts.menu')

@section('menupage-content')

    @if (Session::has('menuitemedited'))
        <div class="alert alert-success">{{ Session::get('menuitemedited') }}</div>
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
        <h3>{{ __('basic::elf.edit_menu_item') }} #{{ $item->id }}</h3>
        <form action="{{ route('admin.menu.items.update',$item->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="colored-rows-box">
                <div class="input-box colored">
                    <label for="menu_id">{{ __('basic::elf.menu') }}</label>
                    <div class="input-wrapper">
                        <select name="menu_id" id="menu_id">
                        @foreach ($menus as $menu)
                            <option value="{{ $menu->id }}" @if($item->menu_id == $menu->id) selected @endif>{{ $menu->name }}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="parent_id">{{ __('basic::elf.parent_item') }}</label>
                    <div class="input-wrapper">
                        <select name="parent_id" id="parent_id">
                            <option value="" data-menu="0">None</option>
                        @foreach ($items as $parent_item)
                            <option value="{{ $parent_item->id }}" @if($item->parent_id == $parent_item->id) selected @endif data-menu="{{ $parent_item->menu_id }}" @if ($parent_item->menu_id != $item->menu_id) style="display:none" @endif>{{ $parent_item->text }}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="text">{{ __('basic::elf.text') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="text" id="text" autocomplete="off" value="{{ $item->text }}">
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="link">{{ __('basic::elf.link') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="link" id="link" autocomplete="off" value="{{ $item->link }}">
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="title">{{ __('basic::elf.title') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="title" id="title" autocomplete="off" value="{{ $item->title }}">
                    </div>
                </div>
                <div class="input-box colored">
                    <div class="checkbox-wrapper">
                        <div class="checkbox-inner">
                            <input
                                type="checkbox"
                                name="clickable"
                                id="clickable"
                                @if($item->clickable == 1) checked @endif
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
                        <input type="text" name="handler" id="handler" autocomplete="off" value="{{ $item->handler }}">
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
                                @forelse ($item->attributes as $attribute_name => $attribute_value)
                                <div class="attributes-table-string-line" data-line="{{$loop->index}}">
                                    <div class="attributes-table-string">
                                        <input type="text" name="attributes_new[{{$loop->index}}][name]" id="attribute_new_name_{{$loop->index}}" data-attribute-name value="{{$attribute_name}}">
                                    </div>
                                    <div class="attributes-table-string">
                                        <input type="text" name="attributes_new[{{$loop->index}}][value]" id="attribute_new_value_{{$loop->index}}" data-attribute-value value="{{$attribute_value}}">
                                    </div>
                                    <div class="attributes-table-string">
                                        <button type="button" class="default-btn" onclick="menuAttrDelete({{$loop->index}})">&#215;</button>
                                    </div>
                                </div>
                                @empty
                                <div class="attributes-table-string-line" data-line="0">
                                    <div class="attributes-table-string">
                                        <input type="text" name="attributes_new[0][name]" id="attribute_new_name_0" data-attribute-name>
                                    </div>
                                    <div class="attributes-table-string">
                                        <input type="text" name="attributes_new[0][value]" id="attribute_new_value_0" data-attribute-value>
                                    </div>
                                    <div class="attributes-table-string">
                                        <button type="button" class="default-btn" onclick="menuAttrDelete(0)">&#215;</button>
                                    </div>
                                </div>
                                @endforelse

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
        menuAttrBoxInit('#addattributeline',{{ count($item->attributes)-1 }})
        selectFilter('#menu_id','#parent_id','data-menu','0')
    </script>

@endsection
