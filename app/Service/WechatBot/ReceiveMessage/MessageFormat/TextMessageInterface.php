<?php

namespace App\Service\WechatBot\ReceiveMessage\MessageFormat;

use App\Service\WechatBot\ReceiveMessage\MessageFormat\GroupChat\GroupChatMessageInterface;
use App\Service\WechatBot\ReceiveMessage\MessageFormat\PrivateChat\PrivateChatMessageInterface;

interface TextMessageInterface extends PrivateChatMessageInterface,GroupChatMessageInterface
{

}