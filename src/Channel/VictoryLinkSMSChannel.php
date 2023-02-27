<?php

namespace MElaraby\VictoryLink\Channel;

use Illuminate\Notifications\Notification;
use JsonException;
use MElaraby\{VictoryLink\Exceptions\MessageEmpty,
    VictoryLink\Exceptions\MethodNotExists,
    VictoryLink\Exceptions\ReceiverNumberEmpty,
    VictoryLink\VictoryLink
};

class VictoryLinkSMSChannel
{
    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param Notification $notification
     * @return void
     * @throws MethodNotExists|ReceiverNumberEmpty
     * @throws MessageEmpty
     * @throws JsonException
     */
    public function send(mixed $notifiable, Notification $notification): void
    {
        if (!method_exists($notifiable, 'toSMS')) {
            throw new MethodNotExists;
        }

        [$receiver, $messageText] = $notification->toSMS($notifiable);

        if (empty($receiver)) {
            throw new ReceiverNumberEmpty;
        }

        if (empty($messageText)) {
            throw new MessageEmpty();
        }

        (new VictoryLink())->send(mobileNumber: $receiver, text: $messageText);
    }
}

