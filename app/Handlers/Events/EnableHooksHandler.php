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

use StyleCI\StyleCI\Events\RepoWasEnabledEvent;
use StyleCI\StyleCI\GitHub\Hooks;

/**
 * This is the enable hooks handler class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class EnableHooksHandler
{
    /**
     * The hooks instance.
     *
     * @var \StyleCI\StyleCI\GitHub\Hooks
     */
    protected $hooks;

    /**
     * Create a new enable hooks handler instance.
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
     * @param \StyleCI\StyleCI\Events\RepoWasEnabledEvent $event
     *
     * @return void
     */
    public function handle(RepoWasEnabledEvent $event)
    {
        $repo = $event->repo;

        // cleanup existing hooks first
        $this->hooks->disable($repo);

        $this->hooks->enable($repo);
    }
}
