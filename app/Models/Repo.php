<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Models;

use Illuminate\Database\Eloquent\Model;
use McCool\LaravelAutoPresenter\HasPresenter;
use StyleCI\StyleCI\Presenters\RepoPresenter;

/**
 * This is the repo model class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 * @author Joseph Cohen <joe@alt-three.com>
 */
class Repo extends Model implements HasPresenter
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * A list of methods protected from mass assignment.
     *
     * @var string[]
     */
    protected $guarded = ['_token', '_method'];

    /**
     * Get the commits relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function commits()
    {
        return $this->hasMany(Commit::class);
    }

    /**
     * Get the forks relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function forks()
    {
        return $this->hasMany(Fork::class);
    }

    /**
     * Get the user relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the last commit.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function lastCommit()
    {
        return $this->hasOne(Commit::class)->where('ref', "refs/heads/{$this->default_branch}")->latest();
    }

    /**
     * Get the presenter class.
     *
     * @return string
     */
    public function getPresenterClass()
    {
        return RepoPresenter::class;
    }
}
