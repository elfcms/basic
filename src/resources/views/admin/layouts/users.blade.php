@extends('basic::admin.layouts.basic')

@section('pagecontent')

<div class="big-container">

    <nav class="subpagenav">
        <ul>
            <li><a href="{{ route('admin.users') }}">Users list</a></li>
            <li><a href="{{ route('admin.users.create') }}">Create user</a></li>
            <li><a href="{{ route('admin.users.roles') }}">Roles list</a></li>
            <li><a href="{{ route('admin.users.roles.create') }}">Create role</a></li>
        </ul>
    </nav>
    @section('userpage-content')
    @show

</div>
@endsection
