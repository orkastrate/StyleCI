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

use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use StyleCI\StyleCI\Commands\CleanupCommitCommand;

/**
 * This is the cleanup command class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class CleanupCommand extends Command
{
    use DispatchesJobs;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'styleci:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Marks all timed out analyses as errored';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->laravel['styleci.commitrepository']->findAllOldPending() as $commit) {
            $this->info("Cleaning up commit {$commit->id}.");
            $this->dispatch(new CleanupCommitCommand($commit));
        }
    }
}
