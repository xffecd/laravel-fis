<?php
namespace Fis;

use Illuminate\Support\ServiceProvider;

class Provider extends ServiceProvider
{
    /**
     * Register fia laravel services.
     *
     * @return void
     */
    public function register() {
        $this->app->singleton('fis', function($app) {
            $path = '';

            if (isset($app['config']['view']['map'])) {
                $path = $app['config']['view']['map'];
            } else {
                $path = realpath(base_path('resources/map'));
            }

            return new Fis($app['files'], $path);
        });

        $this->overrideBlade();
    }

    /**
     * Bootstrap the fis laravel services.
     *
     * @return void
     */
    public function boot() {

        $this->shareFisToView();
        $this->extendBlade();
    }

    protected function overrideBlade() {
        $app = $this->app;

        $app->singleton('blade.compiler', function ($app) {
            $cache = $app['config']['view.compiled'];

            return new Compiler($app['files'], $cache);
        });

        $resolver = $app->make('view.engine.resolver');
        $resolver->register('blade', function() use ($app) {
            return new Engine($app['blade.compiler'], $app['files']);
        });
    }

    protected function shareFisToView() {
        $fis = $this->app->make('fis');
        View::composer('*', function($view) use ($fis) {
            $view->with('__fis', $fis);
        });
    }
}