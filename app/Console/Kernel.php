<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use StyleCI\StyleCI\Console\Commands\CleanupCommand;
use StyleCI\StyleCI\Console\Commands\GarbageCollectCommand;
use StyleCI\StyleCI\Console\Commands\UserCommand;

/**
 * This is the console kernel class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var string[]
     */
    protected $commands = [
        CleanupCommand::class,
        GarbageCollectCommand::class,
        UserCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call('styleci:cleanup')->everyTenMinutes();
        $schedule->call('styleci:gc')->twiceDaily();
    }
}
