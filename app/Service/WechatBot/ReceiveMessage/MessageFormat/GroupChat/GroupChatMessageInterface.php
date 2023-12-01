<?php

namespace App\Service\WechatBot\ReceiveMessage\MessageFormat\GroupChat;

use App\Service\WechatBot\Group\GroupInterface;
use App\Service\WechatBot\ReceiveMessage\MessageFormat\MessageInterface;

interface GroupChatMessageInterface extends MessageInterface
{
    public function toFromGroup():GroupInterface;
}