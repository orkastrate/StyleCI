<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Composers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\View\View;
use McCool\LaravelAutoPresenter\AutoPresenter;

/**
 * This is the current user composer class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 * @author Joseph Cohen <joe@alt-three.com>
 */
class CurrentUserComposer
{
    /**
     * The authentication guard instance.
     *
     * @var \Illuminate\Contracts\Auth\Guard
     */
    protected $auth;

    /**
     * The auto presenter instance.
     *
     * @var \McCool\LaravelAutoPresenter\AutoPresenter
     */
    protected $presenter;

    /**
     * Create a new current user composer instance.
     *
     * @param \Illuminate\Contracts\Auth\Guard           $auth
     * @param \McCool\LaravelAutoPresenter\AutoPresenter $presenter
     *
     * @return void
     */
    public function __construct(Guard $auth, AutoPresenter $presenter)
    {
        $this->auth = $auth;
        $this->presenter = $presenter;
    }

    /**
     * Bind data to the view.
     *
     * @param \Illuminate\Contracts\View\View $view
     *
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('currentUser', $this->presenter->decorate($this->auth->user()));
    }
}
