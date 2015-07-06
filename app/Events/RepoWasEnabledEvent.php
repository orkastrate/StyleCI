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

use StyleCI\StyleCI\Models\Repo;

/**
 * This is the repo was enabled event class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class RepoWasEnabledEvent
{
    /**
     * The repo that was enabled.
     *
     * @var \StyleCI\StyleCI\Models\Repo
     */
    public $repo;

    /**
     * Create a new repo was enabled event instance.
     *
     * @param \StyleCI\StyleCI\Models\Repo $repo
     *
     * @return void
     */
    public function __construct(Repo $repo)
    {
        $this->repo = $repo;
    }
}
