@extends('basic::admin.layouts.form')

@section('formpage-content')

    @if (Session::has('formdeleted'))
    <div class="alert alert-alternate">{{ Session::get('formdeleted') }}</div>
    @endif
    @if (Session::has('formedited'))
    <div class="alert alert-alternate">{{ Session::get('formedited') }}</div>
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
        <table class="grid-table formtable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>{{ __('basic::elf.title') }}</th>
                    <th>{{ __('basic::elf.name') }}</th>
                    <th>{{ __('basic::elf.code') }}</th>
                    <th>{{ __('basic::elf.created') }}</th>
                    <th>{{ __('basic::elf.updated') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach ($forms as $form)
                <tr data-id="{{ $form->id }}">
                    <td class="subline-{{ $form->level }}">{{ $form->id }}</td>
                    <td>
                        <a href="{{ route('admin.form.forms.show',$form->id) }}">
                            {{ $form->title }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('admin.form.forms.show',$form->id) }}">
                            {{ $form->name }}
                        </a>
                    </td>
                    <td>{{ $form->code }}</td>
                    <td>{{ $form->created_at }}</td>
                    <td>{{ $form->updated_at }}</td>
                    <td class="button-column">
                        <form action="{{ route('admin.form.groups.create') }}" method="GET">
                            <input type="hidden" name="form_id" value="{{ $form->id }}">
                            <button type="submit" class="default-btn submit-button">{{ __('basic::elf.add_group') }}</button>
                        </form>
                        <form action="{{ route('admin.form.fields.create') }}" method="GET">
                            <input type="hidden" name="form_id" value="{{ $form->id }}">
                            <button type="submit" class="default-btn submit-button">{{ __('basic::elf.add_field') }}</button>
                        </form>
                        <a href="{{ route('admin.form.forms.edit',$form->id) }}" class="default-btn edit-button">{{ __('basic::elf.edit') }}</a>
                        <form action="{{ route('admin.form.forms.destroy',$form->id) }}" method="POST" data-submit="check">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{ $form->id }}">
                            <input type="hidden" name="name" value="{{ $form->name }}">
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
                    let formId = this.querySelector('[name="id"]').value,
                        formName = this.querySelector('[name="name"]').value,
                        self = this
                    popup({
                        title:'{{ __('basic::elf.deleting_of_element') }}' + formId,
                        content:'<p>{{ __('basic::elf.are_you_sure_to_deleting_form') }} "' + formName + '" (ID ' + formId + ')?</p>',
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
