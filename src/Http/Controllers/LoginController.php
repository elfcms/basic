<?php

namespace Elfcms\Basic\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends \App\Http\Controllers\Controller
{
    public function login(Request $request)
    {
        //dd(Auth::user());
        if (Auth::check()) {
            return redirect()->intended('/admin');
        }

        $fields = $request->only(['email','password']);

        $remember = false;
        if (!empty($request->remember)) {
            $remember = true;
        }
        $fields['is_confirmed'] = 1;

        if (Auth::attempt($fields,$remember)) {
            return redirect()->intended('/admin');
        }

        return redirect(route('basic::admin.login'))->withErrors([
            'email' => 'Error of authentication'
        ]);
    }
}
