<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Presenters;

use McCool\LaravelAutoPresenter\BasePresenter;

/**
 * This is the user presenter class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 * @author Joseph Cohen <joe@alt-three.com>
 */
class UserPresenter extends BasePresenter
{
    /**
     * Get the user's Gravatar URL.
     *
     * @param int $size
     *
     * @return string
     */
    public function gravatar($size = 200)
    {
        return sprintf('https://www.gravatar.com/avatar/%s?size=%d', md5($this->email), $size);
    }

    /**
     * Get the user's first name.
     *
     * @return string
     */
    public function firstName()
    {
        return explode(' ', $this->name)[0];
    }
}
