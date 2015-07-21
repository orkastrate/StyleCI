<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use StyleCI\StyleCI\GitHub\ClientFactory;
use StyleCI\StyleCI\Models\User;

/**
 * This is the user command class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class UserCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'styleci:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Looks for users with bad access tokens';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info('Checking all user accounts.');

        $count = 0;
        $factory = app(ClientFactory::class);

        foreach (User::all() as $user) {
            try {
                $factory->make($user)->me()->show();
            } catch (Exception $e) {
                $count++;
                $this->error("Bad user: {$user->id}, {$user->name}, {$user->username}, {$user->email}");
            }
        }

        $this->info("Found $count bad users.");
    }
}
