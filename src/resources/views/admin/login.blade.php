

@extends('basic::admin.layouts.guest')

@section('head')
    @parent
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('main')
    <h1>{{ $page['title'] ?? $site_settings['title'] }}</h1>
    <div class="container">
        @if (Session::has('toemailconfirm'))
            <div class="alert alert-success">{{ Session::get('toemailconfirm') }}</div>
        @endif
    </div>
    <form action="{{ route('admin.login') }}" method="post" class="col-3 offset-4 border rounded p-2">
        @csrf
        @method('POST')
        <div class="form-group p-2">
            <label for="email" class="col-form-label-lg">Email</label>
            <input type="text" name="email" id="email" class="form-control" placeholder="Email">
            {{-- @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror --}}
        </div>
        <div class="form-group p-2">
            <label for="email" class="col-form-label-lg">Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Password">
            {{-- @error('password')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror --}}
        </div>
        <div class="form-group p-2">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" id="remember" name="remember">
                <label class="form-check-label" for="remember">
                    Remember me
                </label>
            </div>
        </div>
        <div class="form-group p-2">
            <button type="submit" class="btn btn-lg btn-primary" name="sendMe" value="1">Login</button>
        </div>
    </form>

@endsection
