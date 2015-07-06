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
 * This is the enable repo command class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class EnableRepoCommand
{
    /**
     * The repository id.
     *
     * @var int
     */
    public $id;

    /**
     * The repository name.
     *
     * @var string
     */
    public $name;

    /**
     * The associated user.
     *
     * @var \StyleCI\StyleCI\Models\User
     */
    public $user;

    /**
     * Create a new enable repo command instance.
     *
     * @param int                          $id
     * @param string                       $name
     * @param \StyleCI\StyleCI\Models\User $user
     *
     * @return void
     */
    public function __construct($id, $name, User $user)
    {
        $this->id = $id;
        $this->name = $name;
        $this->user = $user;
    }
}
