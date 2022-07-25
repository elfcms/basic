<?php

namespace Elfcms\Basic\Providers;

use Elfcms\Basic\Http\Middleware\AdminUser;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class ElfBasicProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(EventServiceProvider::class);
        /* $this->mergeConfigFrom(
            __DIR__.'/../config/auth.php', 'auth'
        ); */
        require_once __DIR__ . '/../Elf/UrlParams.php';
        require_once __DIR__ . '/../Elf/FormSaver.php';
        require_once __DIR__ . '/../Elf/Helpers.php';
        require_once __DIR__ . '/../Elf/Admin/Menu.php';
        /* if (File::exists(__DIR__ . '/../Elf/UrlParams.php')) {
            require_once __DIR__ . '/../Elf/UrlParams.php';
        }
        if (File::exists(__DIR__ . '/../Elf/FormSaver.php')) {
            require_once __DIR__ . '/../Elf/FormSaver.php';
        }
        if (File::exists(__DIR__ . '/../Elf/Helpers.php')) {
            require_once __DIR__ . '/../Elf/Helpers.php';
        } */
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('UrlParams','Elfcms\Basic\Elf\UrlParams');
        $loader->alias('FormSaver','Elfcms\Basic\Elf\FormSaver');
        $loader->alias('Helpers','Elfcms\Basic\Elf\Helpers');
        $loader->alias('AdminMenu','Elfcms\Basic\Elf\Admin\Menu');

        //$router = $this->app['router'];
        //$router->pushMiddlewareToGroup('web', AdminUser::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'basic');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'basic');

        $this->publishes([
            __DIR__.'/../config/basic.php' => config_path('elfcms/basic.php'),
        ]);

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/elfcms/basic'),
        ]);

        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/basic'),
        ]);

        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/elfcms/basic'),
        ], 'public');

        config(['auth.providers.users.model' => \Elfcms\Basic\Models\User::class]);

        $router->middlewareGroup('admin', array(
            AdminUser::class
        ));
    }
}
