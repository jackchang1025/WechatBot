<?php

namespace App\Event;

use App\Service\WechatBot\ReceiveMessage\MessageFormat\MessageInterface;
use App\Service\WechatBot\User\UserInterface;

class ReceiveMessageEvent
{

    public function __construct(public MessageInterface $message)
    {
    }
}