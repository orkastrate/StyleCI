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

use Exception;
use StyleCI\StyleCI\Events\RepoWasDisabledEvent;
use StyleCI\StyleCI\GitHub\Hooks;

/**
 * This is the disable hooks handler class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class DisableHooksHandler
{
    /**
     * The hooks instance.
     *
     * @var \StyleCI\StyleCI\GitHub\Hooks
     */
    protected $hooks;

    /**
     * Create a new disable hooks handler instance.
     *
     * @param \StyleCI\StyleCI\GitHub\Hooks $hooks
     *
     * @return void
     */
    public function __construct(Hooks $hooks)
    {
        $this->hooks = $hooks;
    }

    /**
     * Handle the event.
     *
     * @param \StyleCI\StyleCI\Events\RepoWasDisabledEvent $event
     *
     * @return void
     */
    public function handle(RepoWasDisabledEvent $event)
    {
        $repo = $event->repo;

        try {
            $this->hooks->disable($repo);
        } catch (Exception $e) {
            // the repo was probably deleted from github
        }
    }
}
