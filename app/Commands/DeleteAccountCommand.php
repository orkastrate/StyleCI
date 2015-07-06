<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Commands;

use StyleCI\StyleCI\Models\User;

/**
 * This is the delete account command class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class DeleteAccountCommand
{
    /**
     * The user to delete.
     *
     * @var \StyleCI\StyleCI\Models\User
     */
    public $user;

    /**
     * Create a new delete account command instance.
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
