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
use StyleCI\StyleCI\Events\RepoWasDisabledEvent;
use StyleCI\StyleCI\Events\RepoWasEnabledEvent;
use StyleCI\StyleCI\Repositories\UserRepository;
use Vinkla\Pusher\PusherManager;

/**
 * This is the real time repo handler class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 * @author Joseph Cohen <joe@alt-three.com>
 */
class RealTimeRepoHandler
{
    /**
     * The user repository instance.
     *
     * @var \StyleCI\StyleCI\Repositories\UserRepository
     */
    protected $userRepository;

    /**
     * The pusher instance.
     *
     * @var \Vinkla\Pusher\PusherManager
     */
    protected $pusher;

    /**
     * The auto presenter instance.
     *
     * @var \McCool\LaravelAutoPresenter\AutoPresenter
     */
    protected $presenter;

    /**
     * Create a new repo notifications handler instance.
     *
     * @param \StyleCI\StyleCI\Repositories\UserRepository $userRepository
     * @param \Vinkla\Pusher\PusherManager                 $pusher
     * @param \McCool\LaravelAutoPresenter\AutoPresenter   $presenter
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository, PusherManager $pusher, AutoPresenter $presenter)
    {
        $this->userRepository = $userRepository;
        $this->pusher = $pusher;
        $this->presenter = $presenter;
    }

    /**
     * Handle the event.
     *
     * @param \StyleCI\StyleCI\Events\RepoWasDisabledEvent|\StyleCI\StyleCI\Events\RepoWasEnabledEvent $event
     *
     * @return void
     */
    public function handle($event)
    {
        if ($event instanceof RepoWasDisabledEvent) {
            $this->trigger($event->repo, 'RepoWasDisabledEvent');
        } elseif ($event instanceof RepoWasEnabledEvent) {
            $this->trigger($event->repo, 'RepoWasEnabledEvent');
        }
    }

    /**
     * Trigger the notification.
     *
     * @param \StyleCI\StyleCI\Models\Repo $repo
     * @param string                       $event
     *
     * @return void
     */
    protected function trigger($repo, $event)
    {
        $users = $this->userRepository->collaborators($repo);
        $data = $this->presenter->decorate($repo);

        foreach ($users as $user) {
            $this->pusher->trigger('repos-'.$user->id, $event, ['event' => $data->toArray()]);
        }
    }
}
