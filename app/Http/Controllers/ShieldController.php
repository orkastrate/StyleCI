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

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use McCool\LaravelAutoPresenter\Facades\AutoPresenter;
use StyleCI\StyleCI\Models\Commit;
use StyleCI\StyleCI\Models\Repo;

/**
 * This is the shield controller class.
 *
 * @author James Brooks <jbrooksuk@me.com>
 */
class ShieldController extends AbstractController
{
    /**
     * Handles a request to serve a shield.
     *
     * @param \StyleCI\StyleCI\Models\Repo $repo
     * @param \Illuminate\Http\Request     $request
     *
     * @return \Illuminate\Http\Response
     */
    public function handle(Repo $repo, Request $request)
    {
        $commit = $repo->commits()->where('ref', "refs/heads/{$repo->default_branch}")->orderBy('created_at', 'desc')->first();

        $shieldUrl = $this->generateShieldUrl($commit, $request->get('style', 'flat-square'));

        return Redirect::to($shieldUrl);
    }

    /**
     * Generate a shields.io url for the commit status.
     *
     * @param \StyleCI\StyleCI\Models\Commit|null $commit
     * @param string                              $style
     *
     * @return string
     */
    protected function generateShieldUrl(Commit $commit = null, $style = 'flat-square')
    {
        $colour = 'lightgrey';
        $status = 'unknown';

        if ($commit) {
            $status = strtolower(AutoPresenter::decorate($commit)->summary);
            if ($commit->status === 1) {
                $colour = 'brightgreen';
            } elseif ($commit->status > 1) {
                $colour = 'red';
            }
        }

        return vsprintf('https://img.shields.io/badge/%s-%s-%s.svg?style=%s', ['StyleCI', $status, $colour, $style]);
    }
}
