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

use Illuminate\Contracts\Mail\MailQueue;
use Illuminate\Mail\Message;
use McCool\LaravelAutoPresenter\AutoPresenter;
use StyleCI\StyleCI\Events\RepoWasDisabledEvent;
use StyleCI\StyleCI\Repositories\UserRepository;

/**
 * This is the repo toggled notification handler class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class RepoToggledNotificationHandler
{
    /**
     * The user repository instance.
     *
     * @var \StyleCI\StyleCI\Repositories\UserRepository
     */
    protected $userRepository;

    /**
     * The mailer instance.
     *
     * @var \Illuminate\Contracts\Mail\MailQueue
     */
    protected $mailer;

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
     * @param \Illuminate\Contracts\Mail\MailQueue         $mailer
     * @param \McCool\LaravelAutoPresenter\AutoPresenter   $presenter
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository, MailQueue $mailer, AutoPresenter $presenter)
    {
        $this->userRepository = $userRepository;
        $this->mailer = $mailer;
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
        $mail = ['repo' => $event->repo->name];

        if ($event instanceof RepoWasDisabledEvent) {
            $mail['subject'] = '[StyleCI] Repo Disabled';
            $view = 'disabled';
        } else {
            $mail['subject'] = '[StyleCI] Repo Enabled';
            $mail['link'] = route('repo_path', $event->repo->id);
            $view = 'enabled';
        }

        foreach ($this->userRepository->collaborators($event->repo) as $user) {
            $mail['email'] = $user->email;
            $mail['name'] = $this->presenter->decorate($user)->firstName;
            $this->mailer->queue(["emails.{$view}-html", "emails.{$view}-text"], $mail, function (Message $message) use ($mail) {
                $message->to($mail['email'])->subject($mail['subject']);
            });
        }
    }
}
