@extends('basic::admin.layouts.users')

@section('userpage-content')

    @if (Session::has('userdeleted'))
    <div class="alert alert-alternate">{{ Session::get('userdeleted') }}</div>
    @endif
    @if (Session::has('useredited'))
    <div class="alert alert-alternate">{{ Session::get('useredited') }}</div>
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
    <div class="widetable-wrapper">
        <table class="grid-table roletable">
            <thead>
                <tr>
                    <th>
                        ID
                        <a href="{{ route('admin.users.roles',UrlParams::addArr(['order'=>'id','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['id'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th>
                        {{ __('basic::elf.name') }}
                        <a href="{{ route('admin.users.roles',UrlParams::addArr(['order'=>'name','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['name'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th>
                        {{ __('basic::elf.code') }}
                        <a href="{{ route('admin.users.roles',UrlParams::addArr(['order'=>'code','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['code'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th>
                        {{ __('basic::elf.description') }}
                        <a href="{{ route('admin.users.roles',UrlParams::addArr(['order'=>'description','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['description'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th>
                        {{ __('basic::elf.created') }}
                        <a href="{{ route('admin.users.roles',UrlParams::addArr(['order'=>'created_at','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['created_at'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th>
                        {{ __('basic::elf.updated') }}
                        <a href="{{ route('admin.users.roles',UrlParams::addArr(['order'=>'updated_at','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['updated_at'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach ($roles as $role)
                <tr data-id="{{ $role->id }}" @if ($notedit && !in_array($role->code,$notedit)) class="editable" @endif>
                    <td>{{ $role->id }}</td>
                    <td>{{ $role->name }}</td>
                    <td>{{ $role->code }}</td>
                    <td>{{ $role->description }}</td>
                    <td>{{ $role->created_at }}</td>
                    <td>{{ $role->updated_at }}</td>
                    <td class="button-column">
                        @if ($notedit && !in_array($role->code,$notedit))
                        <a href="{{ route('admin.users.roles.edit',$role->id) }}" class="default-btn edit-button">{{ __('basic::elf.edit') }}</a>
                        <form action="{{ route('admin.users.roles.destroy',$role->id) }}" method="POST" data-submit="check">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{ $role->id }}">
                            <input type="hidden" name="name" value="{{ $role->name }}">
                            <button type="submit" class="default-btn delete-button">{{ __('basic::elf.delete') }}</button>
                        </form>
                        @endif
                        <div class="contextmenu-content-box">
                            <a href="{{ route('admin.users',UrlParams::addArr(['role'=>$role->id])) }}" class="contextmenu-item">{{ __('basic::elf.show_users') }}</a>
                        @if ($notedit && !in_array($role->code,$notedit))
                            <a href="{{ route('admin.users.roles.edit',$role->id) }}" class="contextmenu-item">{{ __('basic::elf.edit') }}</a>
                            <form action="{{ route('admin.users.roles.destroy',$role->id) }}" method="POST" data-submit="check">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id" value="{{ $role->id }}">
                                <input type="hidden" name="name" value="{{ $role->name }}">
                                <button type="submit" class="contextmenu-item">{{ __('basic::elf.delete') }}</button>
                            </form>
                        @endif
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{$roles->links('basic::admin.layouts.pagination')}}

    <script>
        const checkForms = document.querySelectorAll('form[data-submit="check"]')

        /* if (checkForms) {
            checkForms.forEach(form => {
                form.addEventListener('submit',function(e){
                    e.preventDefault();
                    let roleId = this.querySelector('[name="id"]').value,
                        roleName = this.querySelector('[name="name"]').value,
                        self = this
                    popup({
                        title:'{{ __('basic::elf.deleting_of_element') }}' + roleId,
                        content:'<p>{{ __('basic::elf.are_you_sure_to_deleting_role') }} "' + roleName + '" (ID ' + roleId + ')?</p>',
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
        } */

        function setConfirmDelete(forms) {
            if (forms) {
                forms.forEach(form => {
                    form.addEventListener('submit',function(e){
                        e.preventDefault();
                        let roleId = this.querySelector('[name="id"]').value,
                            roleName = this.querySelector('[name="name"]').value,
                            self = this
                        popup({
                            title:'{{ __('basic::elf.deleting_of_element') }}' + roleId,
                            content:'<p>{{ __('basic::elf.are_you_sure_to_deleting_role') }} "' + roleName + '" (ID ' + roleId + ')?</p>',
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
        }

        setConfirmDelete(checkForms)

        const tablerow = document.querySelectorAll('.roletable tbody tr');
        if (tablerow) {
            tablerow.forEach(row => {
                row.addEventListener('contextmenu',function(e){
                    e.preventDefault()
                    let content = row.querySelector('.contextmenu-content-box').cloneNode(true)
                    let forms  = content.querySelectorAll('form[data-submit="check"]')
                    setConfirmDelete(forms)
                    contextPopup(content,{'left':e.x,'top':e.y})
                })
            })
        }
    </script>

@endsection
