<?php

namespace App\Service\WechatBot\ReceiveMessage\MessageFormat\PrivateChat;

use App\Service\WechatBot\Friend\FriendInterface;
use App\Service\WechatBot\ReceiveMessage\MessageFormat\MessageInterface;

interface PrivateChatMessageInterface extends MessageInterface
{
    public function toFromUser(): FriendInterface;
}