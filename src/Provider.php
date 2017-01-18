<?php
namespace Fis;

use Illuminate\Support\ServiceProvider;
use View;

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
    }

    protected function overrideBlade() {
        $app = $this->app;

        $resolver = $app->make('view.engine.resolver');
        
        $app->singleton('blade.compiler', function ($app) {
            $cache = $app['config']['view.compiled'];

            return new Compiler($app['files'], $cache);
        });

        $resolver->register('blade', function() use ($app) {
            return new Engine($app['blade.compiler'], $app['files']);
        });
        $this->app->singleton('view', function ($app) {
            // Next we need to grab the engine resolver instance that will be used by the
            // environment. The resolver will be used by an environment to get each of
            // the various engine implementations such as plain PHP or Blade engine.
            $resolver = $app['view.engine.resolver'];
            $finder = $app['view.finder'];
            $env = new Factory($resolver, $finder, $app['events']);
            // We will also set the container instance on this view environment since the
            // view composers may be classes registered in the container, which allows
            // for great testable, flexible composers for the application developer.
            $env->setContainer($app);
            $env->share('app', $app);
            return $env;
        });
    }

    protected function shareFisToView() {
        $fis = $this->app->make('fis');
        View::composer('*', function($view) use ($fis) {
            $view->with('__fis', $fis);
        });
    }
}