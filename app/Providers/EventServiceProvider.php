<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

/**
 * This is the event service provider class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'StyleCI\StyleCI\Events\AnalysisHasCompletedEvent' => [
            'StyleCI\StyleCI\Handlers\Events\AnalysisLoggingHandler',
            'StyleCI\StyleCI\Handlers\Events\CommitStatusHandler',
            'StyleCI\StyleCI\Handlers\Events\RealTimeStatusHandler',
            'StyleCI\StyleCI\Handlers\Events\AnalysisNotificationsHandler',
        ],
        'StyleCI\StyleCI\Events\AnalysisHasStartedEvent' => [
            'StyleCI\StyleCI\Handlers\Events\AnalysisLoggingHandler',
        ],
        'StyleCI\StyleCI\Events\AnalysisWasQueuedEvent' => [
            'StyleCI\StyleCI\Handlers\Events\CommitStatusHandler',
            'StyleCI\StyleCI\Handlers\Events\RealTimeStatusHandler',
        ],
        'StyleCI\StyleCI\Events\CleanupHasCompletedEvent' => [
            'StyleCI\StyleCI\Handlers\Events\AnalysisLoggingHandler',
            'StyleCI\StyleCI\Handlers\Events\CommitStatusHandler',
            'StyleCI\StyleCI\Handlers\Events\RealTimeStatusHandler',
            'StyleCI\StyleCI\Handlers\Events\AnalysisNotificationsHandler',
        ],
        'StyleCI\StyleCI\Events\RepoWasDisabledEvent' => [
            'StyleCI\StyleCI\Handlers\Events\DisableHooksHandler',
            'StyleCI\StyleCI\Handlers\Events\RealTimeRepoHandler',
            'StyleCI\StyleCI\Handlers\Events\RepoToggledNotificationHandler',
        ],
        'StyleCI\StyleCI\Events\RepoWasEnabledEvent' => [
            'StyleCI\StyleCI\Handlers\Events\EnableHooksHandler',
            'StyleCI\StyleCI\Handlers\Events\RealTimeRepoHandler',
            'StyleCI\StyleCI\Handlers\Events\RepoToggledNotificationHandler',
        ],
        'StyleCI\StyleCI\Events\UserHasLoggedInEvent' => [
            'StyleCI\StyleCI\Handlers\Events\AuthenticationHandler',
            'StyleCI\StyleCI\Handlers\Events\RepoCacheFlushHandler',
        ],
        'StyleCI\StyleCI\Events\UserHasRageQuitEvent' => [
            'StyleCI\StyleCI\Handlers\Events\RevokeTokenHandler',
            'StyleCI\StyleCI\Handlers\Events\GoodbyeMessageHandler',
        ],
        'StyleCI\StyleCI\Events\UserHasSignedUpEvent' => [
            'StyleCI\StyleCI\Handlers\Events\WelcomeMessageHandler',
        ],
        'illuminate.queue.failed' => [
            'StyleCI\StyleCI\Handlers\Events\FailedJobLoggingHandler',
        ],
    ];
}
