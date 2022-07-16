@extends('basic::admin.layouts.page')

@section('pagepage-content')

    @if (Session::has('pagedeleted'))
    <div class="alert alert-alternate">{{ Session::get('pagedeleted') }}</div>
    @endif
    @if (Session::has('pageedited'))
    <div class="alert alert-alternate">{{ Session::get('pageedited') }}</div>
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
        @if (!empty($category))
            <div class="alert alert-alternate">
                {{ __('basic::elf.showing_results_for_category') }} <strong>#{{ $category->id }} {{ $category->name }}</strong>
            </div>
        @endif
        <table class="grid-table pagetable">
            <thead>
                <tr>
                    <th>
                        ID
                        <a href="{{ route('admin.page.pages',UrlParams::addArr(['order'=>'id','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['id'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th>
                        {{ __('basic::elf.title') }}
                        <a href="{{ route('admin.page.pages',UrlParams::addArr(['order'=>'title','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['title'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th>
                        {{ __('basic::elf.name') }}
                        <a href="{{ route('admin.page.pages',UrlParams::addArr(['order'=>'name','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['name'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th>
                        {{ __('basic::elf.slug') }}
                        <a href="{{ route('admin.page.pages',UrlParams::addArr(['order'=>'slug','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['slug'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th>
                        {{ __('basic::elf.created') }}
                        <a href="{{ route('admin.page.pages',UrlParams::addArr(['order'=>'created_at','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['created_at'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th>
                        {{ __('basic::elf.updated') }}
                        <a href="{{ route('admin.page.pages',UrlParams::addArr(['order'=>'updated_at','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['updated_at'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach ($pages as $page)
                <tr data-id="{{ $page->id }}" class="@empty ($page->active) inactive @endempty">
                    <td>{{ $page->id }}</td>
                    <td>
                        <a href="{{ route('admin.page.pages.edit',$page->id) }}">
                            {{ $page->name }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('admin.page.pages.edit',$page->id) }}">
                            {{ $page->title }}
                        </a>
                    </td>
                    <td>{{ $page->slug }}</td>
                    <td>{{ $page->created_at }}</td>
                    <td>{{ $page->updated_at }}</td>
                    <td class="button-column">
                        <a href="{{ route('admin.page.pages.edit',$page->id) }}" class="default-btn edit-button">{{ __('basic::elf.edit') }}</a>
                        <form action="{{ route('admin.page.pages.destroy',$page->id) }}" method="POST" data-submit="check">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{ $page->id }}">
                            <input type="hidden" name="name" value="{{ $page->name }}">
                            <button type="submit" class="default-btn delete-button">{{ __('basic::elf.delete') }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{$pages->links('admin.layouts.pagination')}}

    <script>
        const checkForms = document.querySelectorAll('form[data-submit="check"]')

        if (checkForms) {
            checkForms.forEach(form => {
                form.addEventListener('submit',function(e){
                    e.preventDefault();
                    let pageId = this.querySelector('[name="id"]').value,
                        pageName = this.querySelector('[name="name"]').value,
                        self = this
                    popup({
                        title:'{{ __('basic::elf.deleting_of_element') }}' + pageId,
                        content:'<p>{{ __('basic::elf.are_you_sure_to_deleting_page') }} "' + pageName + '" (ID ' + pageId + ')?</p>',
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
