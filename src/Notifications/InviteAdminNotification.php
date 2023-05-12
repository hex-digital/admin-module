<?php

declare(strict_types=1);

namespace HexDigital\AdminModule\Notifications;

use HexDigital\AdminModule\Models\Admin;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InviteAdminNotification extends Notification
{
    public function __construct(
        protected Admin $invitedBy,
    ) {
    }

    public function via(Admin $admin): array
    {
        return ['mail'];
    }

    public function toMail(Admin $admin): MailMessage
    {
        /** @var string $appName */
        $appName = config(key: 'app.name', default: '');

        return (new MailMessage())
            ->subject(subject: "You've been invited to join {$appName}")
            ->greeting(greeting: "Hi {$admin->first_name},")
            ->line(line: "You've been invited by {$this->invitedBy->first_name} to join {$appName} as an admin.")
            ->line(line: 'To get started, please click the button below where you will be asked to reset your account password.')
            ->action(text: 'Get Started', url: route(name: 'password.request'))
            ->line(line: "Don't know what this is about? You can safely ignore this email.");
    }
}
