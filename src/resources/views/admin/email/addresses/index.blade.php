@extends('basic::admin.layouts.email')

@section('emailpage-content')

    @if (Session::has('fielddeleted'))
    <div class="alert alert-alternate">{{ Session::get('fielddeleted') }}</div>
    @endif
    @if (Session::has('fieldedited'))
    <div class="alert alert-alternate">{{ Session::get('fieldedited') }}</div>
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
        <table class="grid-table eaddresstable">
            <thead>
                <tr>
                    <th>
                        ID
                        <a href="{{ route('admin.email.addresses',UrlParams::addArr(['order'=>'id','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['id'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th>
                        {{ __('basic::elf.name') }}
                        <a href="{{ route('admin.email.addresses',UrlParams::addArr(['order'=>'name','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['name'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th>
                        {{ __('basic::elf.email') }}
                        <a href="{{ route('admin.email.addresses',UrlParams::addArr(['order'=>'email','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['email'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th>
                        {{ __('basic::elf.created') }}
                        <a href="{{ route('admin.email.addresses',UrlParams::addArr(['order'=>'created_at','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['created_at'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th>
                        {{ __('basic::elf.updated') }}
                        <a href="{{ route('admin.email.addresses',UrlParams::addArr(['order'=>'updated_at','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['updated_at'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach ($addresses as $address)
                <tr data-id="{{ $address->id }}" class="@empty ($address->active) inactive @endempty">
                    <td>{{ $address->id }}</td>
                    <td>
                        <a href="{{ route('admin.email.addresses.edit',$address->id) }}">
                            {{ $address->name }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('admin.email.addresses.edit',$address->id) }}">
                            {{ $address->email }}
                        </a>
                    </td>
                    <td>{{ $address->created_at }}</td>
                    <td>{{ $address->updated_at }}</td>
                    <td class="button-column">
                        <a href="{{ route('admin.email.addresses.edit',$address->id) }}" class="default-btn edit-button">{{ __('basic::elf.edit') }}</a>
                        <form action="{{ route('admin.email.addresses.destroy',$address->id) }}" method="POST" data-submit="check">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{ $address->id }}">
                            <input type="hidden" name="name" value="{{ $address->name }}">
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
                    let addressId = this.querySelector('[name="id"]').value,
                        addressName = this.querySelector('[name="name"]').value,
                        self = this
                    popup({
                        title:'{{ __('basic::elf.deleting_of_element') }}' + addressId,
                        content:'<p>{{ __('basic::elf.are_you_sure_to_deleting_address') }} "' + addressName + '" (ID ' + addressId + ')?</p>',
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
