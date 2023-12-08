<?php

namespace App\Service\ECloud\MessageFormat;

use App\Service\WechatBot\Friend\FriendInterface;
use App\Service\WechatBot\Group\GroupInterface;
use App\Service\WechatBot\ReceiveMessage\MessageFormat\TextMessageInterface;
use App\Service\WechatBot\User\UserInterface;

class TextMessage implements TextMessageInterface
{
    use Message;
}