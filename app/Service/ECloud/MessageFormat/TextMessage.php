<?php

namespace App\Service\ECloud\MessageFormat;

use App\Service\WechatBot\Friend\FriendInterface;
use App\Service\WechatBot\Group\GroupInterface;
use App\Service\WechatBot\ReceiveMessage\MessageFormat\TextMessageInterface;
use App\Service\WechatBot\User\UserInterface;

class TextMessage implements TextMessageInterface
{
    use Message;

    public function toFromGroup(): GroupInterface
    {
        // TODO: Implement toFromGroup() method.
    }

    public function toUser(): UserInterface
    {
        // TODO: Implement toUser() method.
    }

    public function toFromUser(): FriendInterface
    {
        // TODO: Implement toFromUser() method.
    }
}