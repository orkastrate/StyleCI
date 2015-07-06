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

use Github\ResultPager;
use StyleCI\StyleCI\Models\Repo;

/**
 * This is the github branches class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class Branches
{
    /**
     * The github client factory instance.
     *
     * @var \StyleCI\StyleCI\GitHub\ClientFactory
     */
    protected $factory;

    /**
     * Create a new github branches instance.
     *
     * @param \StyleCI\StyleCI\GitHub\ClientFactory $factory
     *
     * @return void
     */
    public function __construct(ClientFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Get the branches from a github repo.
     *
     * @param \StyleCI\StyleCI\Models\Repo $repo
     *
     * @return array
     */
    public function get(Repo $repo)
    {
        $client = $this->factory->make($repo, ['version' => 'quicksilver-preview']);
        $paginator = new ResultPager($client);

        $raw = $paginator->fetchAll($client->repos(), 'branches', explode('/', $repo->name));

        $branches = [];

        foreach ($raw as $branch) {
            if ((strpos($branch['name'], 'gh-pages') === false)) {
                $branches[] = ['name' => $branch['name'], 'commit' => $branch['commit']['sha']];
            }
        }

        return $branches;
    }
}
