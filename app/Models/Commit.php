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
use StyleCI\StyleCI\Presenters\CommitPresenter;

/**
 * This is the commit model class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class Commit extends Model implements HasPresenter
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
     * The attributes that should be casted to native types.
     *
     * @var string[]
     */
    protected $casts = [
        'status'        => 'int',
        'error_message' => 'string',
        'time'          => 'float',
        'memory'        => 'float',
    ];

    /**
     * Get the repo relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function repo()
    {
        return $this->belongsTo(Repo::class);
    }

    /**
     * Get the fork relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fork()
    {
        return $this->belongsTo(Fork::class);
    }

    /**
     * Get the presenter class.
     *
     * @return string
     */
    public function getPresenterClass()
    {
        return CommitPresenter::class;
    }

    /**
     * Get the commit status description.
     *
     * @return string
     */
    public function description()
    {
        switch ($this->status) {
            case 1:
                return 'The StyleCI checks passed';
            case 2:
                return 'The StyleCI checks failed';
            case 3:
                return 'The StyleCI checks have errored';
            case 4:
                return 'The StyleCI checks were misconfigured';
            default:
                return 'The StyleCI checks are pending';
        }
    }

    /**
     * Get the commit's repo name.
     *
     * @return string
     */
    public function name()
    {
        if (empty($this->fork_id)) {
            return $this->repo->name;
        } else {
            return $this->fork->name;
        }
    }
}
