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
use StyleCI\StyleCI\Models\Repo;

/**
 * This is the repo command class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class RepoCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'styleci:repo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Looks for bad or orphaned repos';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info('Checking all repos.');

        $count = 0;
        $factory = app(ClientFactory::class);

        foreach (Repo::all() as $repo) {
            if ($repo->user === null) {
                $count++;
                $this->error("Orphaned repo: {$repo->id}, {$repo->name}");
            } else {
                try {
                    $name = explode('/', $repo->name);
                    $factory->make($repo)->repo()->collaborators()->all($name[0], $name[1]);
                } catch (Exception $e) {
                    $count++;
                    $this->error("Bad repo: {$repo->id}, {$repo->name}");
                }
            }
        }

        $this->info("Found $count bad/orphaned repos.");
    }
}
