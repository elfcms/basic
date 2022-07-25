<?php

namespace Elfcms\Basic\Http\Controllers;

use Elfcms\Basic\Models\FormField;
use Elfcms\Basic\Models\FormFieldType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class AdminController extends \App\Http\Controllers\Controller
{

    public function index()
    {
        //dd(Route::getRoutes());
        //dd(config('basic.elf_menu'));
        //dd(config('elfcms'));
        return view('basic::admin.index',[
            'page' => [
                'title' => 'Administration Panel',
                'current' => url()->current(),
            ],
        ]);
    }

    public function blog()
    {
        return view('basic::admin.blog.index',[
            'page' => [
                'title' => 'Blog',
                'current' => url()->current(),
            ]
        ]);
    }

    public function users()
    {
        return view('basic::admin.users.index',[
            'page' => [
                'title' => 'Users',
                'current' => url()->current(),
            ],
            'currentUser' => Auth::user()
        ]);
    }

    public function settings()
    {
        return view('basic::admin.settings.index',[
            'page' => [
                'title' => 'Settings',
                'current' => url()->current(),
            ]
        ]);
    }

    public function form()
    {
        return view('basic::admin.forms.index',[
            'page' => [
                'title' => 'Forms',
                'current' => url()->current(),
            ]
        ]);
    }

    public function email()
    {
        return view('basic::admin.email.index',[
            'page' => [
                'title' => 'Email',
                'current' => url()->current(),
            ]
        ]);
    }

    public function login()
    {
        if (Auth::check()) {
            return redirect(route('admin.index'));
        }
        return view('basic::admin.login',[
            'page' => [
                'title' => 'Login',
                'current' => url()->current(),
            ]
        ]);
    }

}
