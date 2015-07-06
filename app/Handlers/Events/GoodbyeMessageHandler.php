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
use StyleCI\StyleCI\Events\UserHasRageQuitEvent;

/**
 * This is the goodbye message handler class.
 *
 * @author James Brooks <james@alt-three.com>
 */
class GoodbyeMessageHandler
{
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
     * Create a new welcome message handler instance.
     *
     * @param \Illuminate\Contracts\Mail\MailQueue       $mailer
     * @param \McCool\LaravelAutoPresenter\AutoPresenter $presenter
     *
     * @return void
     */
    public function __construct(MailQueue $mailer, AutoPresenter $presenter)
    {
        $this->mailer = $mailer;
        $this->presenter = $presenter;
    }

    /**
     * Handle the event.
     *
     * @param \StyleCI\StyleCI\Events\UserHasRageQuitEvent $event
     *
     * @return void
     */
    public function handle(UserHasRageQuitEvent $event)
    {
        $user = $event->user;

        $mail = [
            'email'   => $user->email,
            'name'    => $this->presenter->decorate($user)->firstName,
            'subject' => '[StyleCI] Your account has been removed from StyleCI',
        ];

        $this->mailer->queue(['html' => 'emails.goodbye-html', 'text' => 'emails.goodbye-text'], $mail, function (Message $message) use ($mail) {
            $message->to($mail['email'])->subject($mail['subject']);
        });
    }
}
