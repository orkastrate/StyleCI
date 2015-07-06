<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Handlers\Events;

use StyleCI\StyleCI\GitHub\Status;

/**
 * This is the commit status handler class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class CommitStatusHandler
{
    /**
     * The status instance.
     *
     * @var \StyleCI\StyleCI\GitHub\Status
     */
    protected $status;

    /**
     * Create a new commit status handler instance.
     *
     * @param \StyleCI\StyleCI\GitHub\Status $status
     *
     * @return void
     */
    public function __construct(Status $status)
    {
        $this->status = $status;
    }

    /**
     * Handle the event.
     *
     * @param \StyleCI\StyleCI\Events\AnalysisHasStartedEvent|\StyleCI\StyleCI\Events\AnalysisHasCompletedEvent|\StyleCI\StyleCI\Events\CleanupHasCompletedEvent $event
     *
     * @return void
     */
    public function handle($event)
    {
        $this->status->push($event->commit);
    }
}
