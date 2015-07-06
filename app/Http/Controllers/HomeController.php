<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Http\Controllers;

use Illuminate\Support\Facades\View;

/**
 * This is the home controller class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class HomeController extends AbstractController
{
    /**
     * Handles the request to view the homepage.
     *
     * @return \Illuminate\View\View
     */
    public function handle()
    {
        return View::make('index');
    }

    /**
     * Handles the request to view the privacy policy.
     *
     * @return \Illuminate\View\View
     */
    public function handlePrivacy()
    {
        return View::make('policies.privacy');
    }

    /**
     * Handles the request to view the security policy.
     *
     * @return \Illuminate\View\View
     */
    public function handleSecurity()
    {
        return View::make('policies.security');
    }

    /**
     * Handles the request to view the terms of service.
     *
     * @return \Illuminate\View\View
     */
    public function handleTerms()
    {
        return View::make('policies.terms');
    }

    /**
     * Handles the request to view the about page.
     *
     * @return \Illuminate\View\View
     */
    public function handleAbout()
    {
        return View::make('about');
    }
}
