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

use StyleCI\StyleCI\Commands\CleanupCommitCommand;
use StyleCI\StyleCI\Events\CleanupHasCompletedEvent;

/**
 * This is the cleanup commit command handler.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class CleanupCommitCommandHandler
{
    /**
     * Handle the cleanup commit command.
     *
     * @param \StyleCI\StyleCI\Commands\CleanupCommitCommand $command
     *
     * @return void
     */
    public function handle(CleanupCommitCommand $command)
    {
        $commit = $command->commit;

        $commit->status = 3;
        $commit->error_message = 'Analysis of this commit has timed out.';
        $commit->save();

        event(new CleanupHasCompletedEvent($commit));
    }
}
