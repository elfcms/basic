@extends('basic::admin.layouts.form')

@section('formpage-content')

    @if (Session::has('groupdeleted'))
    <div class="alert alert-alternate">{{ Session::get('groupdeleted') }}</div>
    @endif
    @if (Session::has('groupedited'))
    <div class="alert alert-alternate">{{ Session::get('groupedited') }}</div>
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
        <table class="grid-table formgrouptable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>{{ __('basic::elf.form') }}</th>
                    <th>{{ __('basic::elf.title') }}</th>
                    <th>{{ __('basic::elf.name') }}</th>
                    <th>{{ __('basic::elf.code') }}</th>
                    <th>{{ __('basic::elf.created') }}</th>
                    <th>{{ __('basic::elf.updated') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach ($groups as $group)
                <tr data-id="{{ $group->id }}">
                    <td class="subline-{{ $group->level }}">{{ $group->id }}</td>
                    <td>
                        <a href="{{ route('admin.form.forms.edit',$group->form->id) }}">
                            {{ $group->form->title }} [{{ $group->form->id }}]
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('admin.form.groups.edit',$group->id) }}">
                            {{ $group->title }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('admin.form.groups.edit',$group->id) }}">
                            {{ $group->name }}
                        </a>
                    </td>
                    <td>{{ $group->code }}</td>
                    <td>{{ $group->created_at }}</td>
                    <td>{{ $group->updated_at }}</td>
                    <td class="button-column">
                        <form action="{{ route('admin.form.fields.create') }}" method="GET">
                            <input type="hidden" name="group_id" value="{{ $group->id }}">
                            <button type="submit" class="default-btn submit-button">{{ __('basic::elf.add_field') }}</button>
                        </form>
                        <a href="{{ route('admin.form.groups.edit',$group->id) }}" class="default-btn edit-button">{{ __('basic::elf.edit') }}</a>
                        <form action="{{ route('admin.form.groups.destroy',$group->id) }}" method="POST" data-submit="check">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{ $group->id }}">
                            <input type="hidden" name="name" value="{{ $group->name }}">
                            <button type="submit" class="default-btn delete-button">{{ __('basic::elf.delete') }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <script>
        const checkGroups = document.querySelectorAll('form[data-submit="check"]')

        if (checkGroups) {
            checkGroups.forEach(group => {
                group.addEventListener('submit',function(e){
                    e.preventDefault();
                    let groupId = this.querySelector('[name="id"]').value,
                        groupName = this.querySelector('[name="name"]').value,
                        self = this
                    popup({
                        title:'{{ __('basic::elf.deleting_of_element') }}' + groupId,
                        content:'<p>{{ __('basic::elf.are_you_sure_to_deleting_group') }} "' + groupName + '" (ID ' + groupId + ')?</p>',
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
