<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Handlers\Events;

use McCool\LaravelAutoPresenter\AutoPresenter;
use Psr\Log\LoggerInterface;
use StyleCI\StyleCI\Events\CleanupHasCompletedEvent;
use StyleCI\StyleCI\Models\Commit;

/**
 * This is the analysis logging handler class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class AnalysisLoggingHandler
{
    /**
     * The logger instance.
     *
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * The auto presenter instance.
     *
     * @var \McCool\LaravelAutoPresenter\AutoPresenter
     */
    protected $presenter;

    /**
     * Create a new analysis logging handler instance.
     *
     * @param \Psr\Log\LoggerInterface                   $logger
     * @param \McCool\LaravelAutoPresenter\AutoPresenter $presenter
     *
     * @return void
     */
    public function __construct(LoggerInterface $logger, AutoPresenter $presenter)
    {
        $this->logger = $logger;
        $this->presenter = $presenter;
    }

    /**
     * Handle the event.
     *
     * @param \StyleCI\StyleCI\Events\AnalysisHasStartedEvent|\StyleCI\StyleCI\Events\AnalysisHasCompletedEvent|\StyleCI\StyleCI\Events\CleanupHasCompletedEvent $event
     *
     * @return void
     */
    public function handle($event)
    {
        $commit = $event->commit;

        if (isset($event->exception)) {
            $this->logger->notice($event->exception);
        }

        if ($event instanceof CleanupHasCompletedEvent) {
            $this->logger->error('Analysis has failed due to it timing out.', $this->getContext($commit));

            return; // if we've cleaned up a commit, stop here
        }

        switch ($commit->status) {
            case 0:
                $this->logger->debug('Analysis has started.', $this->getContext($commit));
                break;
            case 1:
            case 2:
                $this->logger->debug('Analysis has completed successfully.', $this->getContext($commit));
                break;
            case 3:
                $this->logger->error('Analysis of has failed due to an internal error.', $this->getContext($commit));
                break;
            case 4:
                $this->logger->notice('Analysis of has failed due to misconfiguration.', $this->getContext($commit));
                break;
        }
    }

    /**
     * Get the context.
     *
     * @param \StyleCI\StyleCI\Models\Commit $commit
     *
     * @return array
     */
    protected function getContext(Commit $commit)
    {
        return ['commit' => $this->presenter->decorate($commit)->toArray()];
    }
}
