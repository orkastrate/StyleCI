<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Providers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Support\ServiceProvider;
use StyleCI\StyleCI\Composers\CurrentUrlComposer;
use StyleCI\StyleCI\Composers\CurrentUserComposer;

/**
 * This is the view composer service provider class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 * @author Joseph Cohen <joe@alt-three.com>
 */
class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @param \Illuminate\Contracts\View\Factory $factory
     *
     * @return void
     */
    public function boot(Factory $factory)
    {
        $factory->composer('*', CurrentUserComposer::class);
        $factory->composer('*', CurrentUrlComposer::class);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
