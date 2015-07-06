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
use StyleCI\StyleCI\Commit\Diff;

/**
 * This is the commit presenter class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 * @author Joseph Cohen <joe@alt-three.com>
 */
class CommitPresenter extends BasePresenter implements Arrayable
{
    /**
     * Get the commit status summary.
     *
     * @return string
     */
    public function summary()
    {
        switch ($this->wrappedObject->status) {
            case 1:
                return 'PASSED';
            case 2:
                return 'FAILED';
            case 3:
                return 'ERRORED';
            case 4:
                return 'MISCONFIGURED';
            default:
                return 'PENDING';
        }
    }

    /**
     * Get the commit status icon.
     *
     * @return string
     */
    public function icon()
    {
        if ($this->wrappedObject->status == 1) {
            return 'fa fa-check-circle';
        }

        if ($this->wrappedObject->status > 2) {
            return 'fa fa-times-circle';
        }

        return 'fa fa-exclamation-circle';
    }

    /**
     * Get the commit's repo shorthand id.
     *
     * @return string
     */
    public function shorthandId()
    {
        return substr($this->wrappedObject->id, 0, 6);
    }

    /**
     * Get the commit's time ago.
     *
     * @return string
     */
    public function timeAgo()
    {
        return $this->wrappedObject->created_at->diffForHumans();
    }

    /**
     * Get the commit's created time ISO.
     *
     * @return string
     */
    public function createdAtToISO()
    {
        return $this->wrappedObject->created_at->toIso8601String();
    }

    /**
     * Get the diff splited to files.
     *
     * @return \StyleCI\StyleCI\Commit\Diff
     */
    public function diff()
    {
        return new Diff($this->wrappedObject->diff);
    }

    /**
     * Get the commit status description.
     *
     * @return string
     */
    public function description()
    {
        return $this->wrappedObject->description();
    }

    /**
     * Convert presented commit to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id'             => $this->wrappedObject->id,
            'repo_id'        => $this->wrappedObject->repo_id,
            'repo_name'      => $this->wrappedObject->repo->name,
            'message'        => $this->wrappedObject->message,
            'description'    => $this->wrappedObject->description(),
            'error_message'  => $this->wrappedObject->error_message,
            'status'         => $this->wrappedObject->status,
            'summary'        => $this->summary(),
            'icon'           => $this->icon(),
            'timeAgo'        => $this->timeAgo(),
            'shorthandId'    => $this->shorthandId(),
            'createdAtToISO' => $this->createdAtToISO(),
            'link'           => route('commit_path', $this->wrappedObject->id),
        ];
    }
}
