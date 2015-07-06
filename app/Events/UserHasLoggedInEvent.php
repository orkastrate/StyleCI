<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Events;

use StyleCI\StyleCI\Models\User;

/**
 * This is the user has logged in event class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class UserHasLoggedInEvent
{
    /**
     * The user that has logged in.
     *
     * @var \StyleCI\StyleCI\Models\User
     */
    public $user;

    /**
     * Create a new user has logged in event instance.
     *
     * @param \StyleCI\StyleCI\Models\User $user
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
