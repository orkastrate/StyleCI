<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\Tests\StyleCI;

use GrahamCampbell\TestBenchCore\LaravelTrait;
use GrahamCampbell\TestBenchCore\ServiceProviderTrait;
use StyleCI\StyleCI\GitHub\Branches;
use StyleCI\StyleCI\GitHub\ClientFactory;
use StyleCI\StyleCI\GitHub\Status;
use StyleCI\StyleCI\Providers\AppServiceProvider;

/**
 * This is the service provider test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class ServiceProviderTest extends AbstractTestCase
{
    use LaravelTrait, ServiceProviderTrait;

    protected function getServiceProviderClass($app)
    {
        return AppServiceProvider::class;
    }

    public function testClientFactoryIsInjectable()
    {
        $this->assertIsInjectable(ClientFactory::class);
    }

    public function testGitHubBranchesIsInjectable()
    {
        $this->assertIsInjectable(Branches::class);
    }

    public function testGitHubStatusIsInjectable()
    {
        $this->assertIsInjectable(Status::class);
    }
}
