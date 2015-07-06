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

/**
 * This is the login command class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 * @author Joseph Cohen <joe@alt-three.com>
 */
class LoginCommand
{
    /**
     * The user's id.
     *
     * @var string
     */
    public $id;

    /**
     * The user's name.
     *
     * @var string
     */
    public $name;

    /**
     * The user's username.
     *
     * @var string
     */
    public $username;

    /**
     * The user's email address.
     *
     * @var string
     */
    public $email;

    /**
     * The user's access token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a new login command instance.
     *
     * @param string $id
     * @param string $name
     * @param string $username
     * @param string $email
     * @param string $token
     *
     * @return void
     */
    public function __construct($id, $name, $username, $email, $token)
    {
        $this->id = $id;
        $this->name = $name;
        $this->username = $username;
        $this->email = $email;
        $this->token = $token;
    }
}
