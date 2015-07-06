<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\Tests\StyleCI\Functional;

use Illuminate\Contracts\Console\Kernel;
use StyleCI\Tests\StyleCI\AbstractTestCase;

/**
 * This is the command test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class CommandTest extends AbstractTestCase
{
    public function testInstall()
    {
        $this->assertSame(0, $this->app->make(Kernel::class)->call('app:install'));
    }

    public function testReset()
    {
        $this->assertSame(0, $this->app->make(Kernel::class)->call('migrate', ['--force' => true]));
        $this->assertSame(0, $this->app->make(Kernel::class)->call('app:reset'));
    }

    public function testUpdate()
    {
        $this->assertSame(0, $this->app->make(Kernel::class)->call('app:update'));
    }

    public function testResetAfterInstall()
    {
        $this->assertSame(0, $this->app->make(Kernel::class)->call('app:install'));
        $this->assertSame(0, $this->app->make(Kernel::class)->call('app:reset'));
    }
}
