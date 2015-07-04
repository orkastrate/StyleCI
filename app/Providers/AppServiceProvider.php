<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three LTD <support@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Providers;

use Illuminate\Bus\Dispatcher;
use Illuminate\Support\ServiceProvider;
use StyleCI\StyleCI\Http\Middleware\Authenticate;

/**
 * This is the app service provider class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @param \Illuminate\Bus\Dispatcher $dispatcher
     *
     * @return void
     */
    public function boot(Dispatcher $dispatcher)
    {
        $dispatcher->mapUsing(function ($command) {
            return Dispatcher::simpleMapping($command, 'StyleCI\StyleCI\Commands', 'StyleCI\StyleCI\Handlers\Commands');
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerAuthenticate();
    }

    /**
     * Register the auth middleware.
     *
     * @return void
     */
    protected function registerAuthenticate()
    {
        $this->app->singleton(Authenticate::class, function ($app) {
            $auth = $app['auth.driver'];
            $allowed = $app->config->get('login.allowed', []);

            return new Authenticate($auth, $allowed);
        });
    }
}
