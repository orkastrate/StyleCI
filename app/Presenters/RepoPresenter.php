<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Presenters;

use Illuminate\Contracts\Support\Arrayable;
use McCool\LaravelAutoPresenter\BasePresenter;
use McCool\LaravelAutoPresenter\Facades\AutoPresenter;

/**
 * This is the repo presenter class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 * @author Joseph Cohen <joe@alt-three.com>
 */
class RepoPresenter extends BasePresenter implements Arrayable
{
    /**
     * Get the last commit.
     *
     * @return \StyleCI\StyleCI\Presenters\CommitPresenter|null
     */
    public function lastCommit()
    {
        $commit = $this->wrappedObject->lastCommit;

        if ($commit) {
            return AutoPresenter::decorate($commit);
        }
    }

    /**
     * Convert presented repo to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id'          => $this->wrappedObject->id,
            'name'        => $this->wrappedObject->name,
            'last_commit' => $this->lastCommit(),
            'link'        => route('repo_path', $this->wrappedObject->id),
        ];
    }
}
