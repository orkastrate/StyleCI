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

use StyleCI\StyleCI\Commands\EnableRepoCommand;
use StyleCI\StyleCI\Events\RepoWasEnabledEvent;
use StyleCI\StyleCI\Models\Repo;

/**
 * This is the enable repo command handler class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class EnableRepoCommandHandler
{
    /**
     * Handle the enable repo command.
     *
     * @param \StyleCI\StyleCI\Commands\EnableRepoCommand $command
     *
     * @return void
     */
    public function handle(EnableRepoCommand $command)
    {
        $repo = new Repo();

        $repo->id = $command->id;
        $repo->name = $command->name;
        $repo->user_id = $command->user->id;

        $repo->save();

        event(new RepoWasEnabledEvent($repo));
    }
}
