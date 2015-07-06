<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Handlers\Commands;

use StyleCI\StyleCI\Commands\LoginCommand;
use StyleCI\StyleCI\Events\UserHasLoggedInEvent;
use StyleCI\StyleCI\Events\UserHasSignedUpEvent;
use StyleCI\StyleCI\Models\User;
use StyleCI\StyleCI\Repositories\UserRepository;

/**
 * This is the login command handler class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 * @author Joseph Cohen <joe@alt-three.com>
 */
class LoginCommandHandler
{
    /**
     * The user repository instance.
     *
     * @var \StyleCI\StyleCI\Repositories\UserRepository
     */
    protected $userRepository;

    /**
     * Create a new login command handler instance.
     *
     * @param \StyleCI\StyleCI\Repositories\UserRepository $userRepository
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Handle the login command.
     *
     * @param \StyleCI\StyleCI\Commands\LoginCommand $command
     *
     * @return void
     */
    public function handle(LoginCommand $command)
    {
        $user = $this->userRepository->findOrGenerate($command->id);

        $new = $user->exists === false;

        $user->name = $command->name;
        $user->email = $command->email;
        $user->username = $command->username;
        $user->access_token = $command->token;

        $user->save();

        if ($new) {
            event(new UserHasSignedUpEvent($user));
        }

        event(new UserHasLoggedInEvent($user));
    }
}
