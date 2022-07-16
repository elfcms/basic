@extends('basic::admin.layouts.menu')

@section('menupage-content')

    @if (Session::has('menudeleted'))
    <div class="alert alert-alternate">{{ Session::get('menudeleted') }}</div>
    @endif
    @if (Session::has('menuedited'))
    <div class="alert alert-alternate">{{ Session::get('menuedited') }}</div>
    @endif
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="widetable-wrapper">
        <table class="grid-table menutable">
            <thead>
                <tr>
                    <th>
                        ID
                        <a href="{{ route('admin.menu.menus',UrlParams::addArr(['order'=>'id','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['id'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th>
                        {{ __('basic::elf.name') }}
                        <a href="{{ route('admin.menu.menus',UrlParams::addArr(['order'=>'name','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['name'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th>
                        {{ __('basic::elf.code') }}
                        <a href="{{ route('admin.menu.menus',UrlParams::addArr(['order'=>'code','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['code'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th>
                        {{ __('basic::elf.created') }}
                        <a href="{{ route('admin.menu.menus',UrlParams::addArr(['order'=>'created_at','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['created_at'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th>
                        {{ __('basic::elf.updated') }}
                        <a href="{{ route('admin.menu.menus',UrlParams::addArr(['order'=>'updated_at','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['updated_at'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach ($menus as $menu)
                <tr data-id="{{ $menu->id }}" class="@empty ($menu->active) inactive @endempty">
                    <td>{{ $menu->id }}</td>
                    <td>
                        <a href="{{ route('admin.menu.menus.show',$menu->id) }}">
                            {{ $menu->name }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('admin.menu.menus.show',$menu->id) }}">
                            {{ $menu->code }}
                        </a>
                    </td>
                    <td>{{ $menu->created_at }}</td>
                    <td>{{ $menu->updated_at }}</td>
                    <td class="button-column">
                        <form action="{{ route('admin.menu.items.create') }}" method="GET">
                            <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                            <button type="submit" class="default-btn submit-button">{{ __('basic::elf.add_item') }}</button>
                        </form>
                        <a href="{{ route('admin.menu.menus.edit',$menu->id) }}" class="default-btn edit-button">{{ __('basic::elf.edit') }}</a>
                        <form action="{{ route('admin.menu.menus.destroy',$menu->id) }}" method="POST" data-submit="check">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{ $menu->id }}">
                            <input type="hidden" name="name" value="{{ $menu->name }}">
                            <button type="submit" class="default-btn delete-button">{{ __('basic::elf.delete') }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <script>
        const checkForms = document.querySelectorAll('form[data-submit="check"]')

        if (checkForms) {
            checkForms.forEach(form => {
                form.addEventListener('submit',function(e){
                    e.preventDefault();
                    let menuId = this.querySelector('[name="id"]').value,
                        menuName = this.querySelector('[name="name"]').value,
                        self = this
                    popup({
                        title:'{{ __('basic::elf.deleting_of_element') }}' + menuId,
                        content:'<p>{{ __('basic::elf.are_you_sure_to_deleting_menu') }} "' + menuName + '" (ID ' + menuId + ')?</p>',
                        buttons:[
                            {
                                title:'{{ __('basic::elf.delete') }}',
                                class:'default-btn delete-button',
                                callback: function(){
                                    self.submit()
                                }
                            },
                            {
                                title:'{{ __('basic::elf.cancel') }}',
                                class:'default-btn cancel-button',
                                callback:'close'
                            }
                        ],
                        class:'danger'
                    })
                })
            })
        }
    </script>
@endsection
