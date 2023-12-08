<?php

namespace App\Listener;

use App\Event\ReceiveMessageEvent;
use App\Service\WechatBot\ReceiveMessage\MessageFormat\TextMessageInterface;
use Hyperf\Event\Annotation\Listener;
use Hyperf\Event\Contract\ListenerInterface;

#[Listener]
class ReceiveMessageListener implements ListenerInterface
{

    public function listen(): array
    {
        return [
            ReceiveMessageEvent::class,
        ];
    }

    public function process(object $event): void
    {

        /**
         * @var ReceiveMessageEvent $event
         */
        var_dump($event->message->toUser(), $event->message->getFromUser());

        if ($event->message instanceof TextMessageInterface){
            $user = $event->message->toUser();

            //回复消息
            $user->send($event->message->toFromUser(), $event->message->getContent());
        }

    }
}