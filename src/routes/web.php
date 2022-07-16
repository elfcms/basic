<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Route;

Route::get('/test', function() {
    //dd(config('basic.version'));
    return view('basic::test');
});

Route::group(['middleware'=>['web']],function(){

/* Route::name('user.')->group(function(){
    Route::get('/private', [\App\Http\Controllers\User\PrivateController::class, 'user'])->middleware('auth')->name('private');

    Route::get('/login', function () {
        if(Auth::check()){
            return redirect(route('user.private'));
        }
        return view('user.login', [
            'pageTitle' => 'Login'
        ]);
    })->name('login');

    Route::post('/login', [\App\Http\Controllers\User\LoginController::class, 'login']);

    Route::get('/logout', function(){
        Auth::logout();
        return redirect('/');
    })->name('logout');

    Route::get('/registration', function ()
    {
        if(Auth::check()){
            return redirect(route('private'));
        }
        return view('user.registration');
    })->name('registration');

    Route::post('/registration',[\App\Http\Controllers\User\RegisterController::class, 'create']);
    Route::post('/form-submit',[\App\Http\Controllers\Publics\FormSubmitController::class, 'submit']);

    Route::get('confirm-email/{email}/{token}', [\App\Http\Controllers\User\EmailConfirmController::class, 'confirm'])->name('confirm-email');
}); */

//Route::name('admin.')->middleware(\Elfcms\Basic\Http\Middleware\AdminUser::class)->middleware('web')->group(function(){
//Route::name('admin.')->middleware(['web','admin'])->group(function(){
Route::name('admin.')->middleware('admin')->group(function(){

    Route::name('settings.')->group(function(){
        Route::get('/admin/settings',[Elfcms\Basic\Http\Controllers\SettingController::class,'index'])->name('index');
        Route::post('/admin/settings',[Elfcms\Basic\Http\Controllers\SettingController::class,'save'])->name('save');
    });

    Route::get('/admin',[Elfcms\Basic\Http\Controllers\AdminController::class,'index'])
    ->name('index');
    Route::get('/admin/login',[Elfcms\Basic\Http\Controllers\AdminController::class,'login'])
    ->name('login');
    Route::post('/admin/login', [Elfcms\Basic\Http\Controllers\LoginController::class, 'login']);
    Route::get('/admin/logout', function(){
        Auth::logout();
        return redirect('/admin/login');
    })->name('logout');
    Route::resource('/admin/users/roles', Elfcms\Basic\Http\Controllers\Resources\RoleController::class)->names([
        'index' => 'users.roles',
        'create' => 'users.roles.create',
        'edit' => 'users.roles.edit',
        'store' => 'users.roles.store',
        'show' => 'users.roles.show',
        'edit' => 'users.roles.edit',
        'update' => 'users.roles.update',
        'destroy' => 'users.roles.destroy'
    ]);
    Route::resource('/admin/users', Elfcms\Basic\Http\Controllers\Resources\UserController::class)->names(['index' => 'users']);

    Route::get('/admin/ajax/json/lang/{name}',function(Request $request ,$name){
        $result = [];
        if ($request->ajax()) {
            if (Lang::has($name)) {
                $result = Lang::get($name);
            }
        }
        return json_encode($result);
    });


    Route::name('email.')->group(function(){
        Route::resource('/admin/email/addresses', Elfcms\Basic\Http\Controllers\Resources\EmailAddressController::class)->names(['index' => 'addresses']);
        Route::resource('/admin/email/events', Elfcms\Basic\Http\Controllers\Resources\EmailEventController::class)->names(['index' => 'events']);
        Route::resource('/admin/email/templates', Elfcms\Basic\Http\Controllers\Resources\EmailTemplateController::class)->names(['index' => 'templates']);
    });

    Route::get('/admin/email',[Elfcms\Basic\Http\Controllers\AdminController::class,'email'])
    ->name('email');

    /* Route::get('/admin/blog',[\App\Http\Controllers\AdminController::class,'blog'])
    ->name('blog');

    Route::name('blog.')->group(function(){
        Route::resource('/admin/blog/categories', App\Http\Controllers\Resources\BlogCategoryController::class)->names(['index' => 'categories']);
        Route::resource('/admin/blog/posts', App\Http\Controllers\Resources\BlogPostController::class)->names(['index' => 'posts']);
        Route::post('/admin/blog/tags/addnotexist', [App\Http\Controllers\Resources\BlogTagController::class,'addNotExist'])->name('tags.addnotexist');
        Route::resource('/admin/blog/tags', App\Http\Controllers\Resources\BlogTagController::class)->names(['index' => 'tags']);
        Route::resource('/admin/blog/comments', App\Http\Controllers\Resources\BlogCommentController::class)->names(['index' => 'comments']);
        Route::resource('/admin/blog/votes', App\Http\Controllers\Resources\BlogVoteController::class)->names(['index' => 'votes']);
        Route::resource('/admin/blog/likes', App\Http\Controllers\Resources\BlogLikeController::class)->names(['index' => 'likes']);
    });

    Route::name('form.')->group(function(){
        Route::resource('/admin/form/forms', App\Http\Controllers\Resources\FormController::class)->names(['index' => 'forms']);
        Route::resource('/admin/form/groups', App\Http\Controllers\Resources\FormFieldGroupController::class)->names(['index' => 'groups']);
        Route::resource('/admin/form/fields', App\Http\Controllers\Resources\FormFieldController::class)->names(['index' => 'fields']);
        Route::resource('/admin/form/options', App\Http\Controllers\Resources\FormFieldOptionController::class)->names(['index' => 'options']);
        Route::resource('/admin/form/field-types', App\Http\Controllers\Resources\FormController::class)->names(['index' => 'field-types']);
        Route::resource('/admin/form/results', App\Http\Controllers\Resources\FormResultController::class)->names(['index' => 'results']);
    });


    Route::name('menu.')->group(function(){
        Route::resource('/admin/menu/menus', App\Http\Controllers\Resources\MenuController::class)->names(['index' => 'menus']);
        Route::resource('/admin/menu/items', App\Http\Controllers\Resources\MenuItemController::class)->names(['index' => 'items']);
    });

    Route::name('page.')->group(function(){
        Route::resource('/admin/page/pages', App\Http\Controllers\Resources\PageController::class)->names(['index' => 'pages']);
    });



    Route::get('/admin/form',[\App\Http\Controllers\AdminController::class,'form'])
    ->name('form');
    Route::get('/admin/email',[\App\Http\Controllers\AdminController::class,'email'])
    ->name('email');
    Route::get('/admin/test',[\App\Http\Controllers\AdminController::class,'test'])
    ->name('test'); */
});
});
