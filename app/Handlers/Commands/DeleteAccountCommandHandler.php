<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Handlers\Commands;

use Exception;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Psr\Log\LoggerInterface;
use StyleCI\StyleCI\Commands\DeleteAccountCommand;
use StyleCI\StyleCI\Commands\DisableRepoCommand;
use StyleCI\StyleCI\Events\UserHasRageQuitEvent;

/**
 * This is the delete account command handler class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class DeleteAccountCommandHandler
{
    use DispatchesJobs;

    /**
     * The logger instance.
     *
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * Create a new delete account command handler instance.
     *
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return void
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Handle the delete account command.
     *
     * @param \StyleCI\StyleCI\Commands\DeleteAccountCommand $command
     *
     * @return void
     */
    public function handle(DeleteAccountCommand $command)
    {
        $user = $command->user;

        foreach ($user->repos as $repo) {
            try {
                $this->dispatch(new DisableRepoCommand($repo));
            } catch (Exception $e) {
                $this->logger->error($e);
            }
        }

        try {
            event(new UserHasRageQuitEvent($user));
        } catch (Exception $e) {
            $this->logger->error($e);
        }

        $user->delete();
    }
}
