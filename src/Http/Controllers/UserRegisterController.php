<?php

namespace Elfcms\Basic\Http\Controllers;

use Elfcms\Basic\Models\Role;
use Elfcms\Basic\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;

class UserRegisterController extends \App\Http\Controllers\Controller
{
    public function create(Request $request)
    {

        if (Auth::check()) {
            return redirect(route('user.private'));
        }

        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed'
        ]);

        if (User::where('email',$validated['email'])->exists()) {
            return redirect(route('user.registration'))->withErrors([
                'email' => 'User already exists'
            ]);
        }

        $roleCode = Config::get('elf.user_default_role');

        if (!$roleCode) {
            $roleCode = 'users';
        }

        $role = Role::where('code',$roleCode)->first();

        $user = User::create($validated);
        if ($user) {

            $user->assignRole($role);

            if (Config::get('elf.email_confirmation')) {
                $user->getConfirmationToken();
                $message = Lang::get('elf.email_confirmation');
                if (!$message) {
                    $message = 'A verification link has been sent to your email account.';
                }
                return redirect(route('user.login'))->with('toemailconfirm',$message);
            }

            Auth::login($user);
            return redirect(route('user.private'))->withErrors([
                'err' => $user
            ]);
        }

        return redirect(route('user.registration'))->withErrors([
            'formError' => 'Error of creating user'
        ]);
    }
}
