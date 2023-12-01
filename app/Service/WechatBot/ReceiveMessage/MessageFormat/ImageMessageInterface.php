<?php

namespace App\Service\WechatBot\ReceiveMessage\MessageFormat;

use App\Service\WechatBot\ReceiveMessage\MessageFormat\GroupChat\GroupChatMessageInterface;
use App\Service\WechatBot\ReceiveMessage\MessageFormat\PrivateChat\PrivateChatMessageInterface;

interface ImageMessageInterface extends PrivateChatMessageInterface,GroupChatMessageInterface
{
    public function getImg():string;

    public function downloadImage();
}