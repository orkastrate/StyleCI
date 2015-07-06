<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\GitHub;

use GrahamCampbell\GitHub\GitHubFactory;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use StyleCI\StyleCI\Models\Repo;
use StyleCI\StyleCI\Models\User;

/**
 * This is the github client factory class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class ClientFactory
{
    /**
     * The github repo instance.
     *
     * @var \GrahamCampbell\GitHub\GitHubFactory
     */
    protected $factory;

    /**
     * Create a new github client factory instance.
     *
     * @param \GrahamCampbell\GitHub\GitHubFactory $factory
     *
     * @return void
     */
    public function __construct(GitHubFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Get the github api client for a model.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param array                               $options
     *
     * @throws \InvalidArgumentException
     *
     * @return \Github\Client
     */
    public function make(Model $model, $options = [])
    {
        switch (get_class($model)) {
            case User::class:
                $token = $model->access_token;
                break;
            case Repo::class:
                $token = $model->user->access_token;
                break;
            default:
                throw new InvalidArgumentException('You must provide a user or repo model.');
        }

        return $this->factory->make(array_merge(['token' => $token, 'method' => 'token'], $options));
    }
}
