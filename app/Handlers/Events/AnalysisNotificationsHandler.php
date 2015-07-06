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
use StyleCI\StyleCI\Models\Commit;
use StyleCI\StyleCI\Repositories\UserRepository;

/**
 * This is the analysis notification handler class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class AnalysisNotificationsHandler
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
     * Create a new analysis notifications handler instance.
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
     * @param \StyleCI\StyleCI\Events\AnalysisHasCompletedEvent|\StyleCI\StyleCI\Events\CleanupHasCompletedEvent $event
     *
     * @return void
     */
    public function handle($event)
    {
        $commit = $event->commit;

        // if the analysis didn't fail, then we don't need to notify anyone
        if ($commit->status < 2) {
            return;
        }

        // don't send out notifications for analyses of forks
        if ($commit->fork_id) {
            return;
        }

        $this->sendMessages($commit);
    }

    /**
     * Send out messages to the relevant users.
     *
     * We're emailing all repo collaborators that have accounts on StyleCI.
     *
     * @todo Allow users to set their notification preferences, and support
     * notifying users though other mediums than just email.
     *
     * @param \StyleCI\StyleCI\Models\Commit $commit
     *
     * @return void
     */
    protected function sendMessages(Commit $commit)
    {
        $mail = [
            'repo'    => $commit->name(),
            'commit'  => $commit->message,
            'link'    => route('commit_path', $commit->id),
            'subject' => '[StyleCI] Failed Analysis',
        ];

        if ($commit->status === 3) {
            $status = 'errored';
        } elseif ($commit->status === 4) {
            $status = 'misconfigured';
        } else {
            $status = 'failed';
        }

        foreach ($this->userRepository->collaborators($commit) as $user) {
            $mail['email'] = $user->email;
            $mail['name'] = $this->presenter->decorate($user)->firstName;
            $this->mailer->queue(["emails.{$status}-html", "emails.{$status}-text"], $mail, function (Message $message) use ($mail) {
                $message->to($mail['email'])->subject($mail['subject']);
            });
        }
    }
}
