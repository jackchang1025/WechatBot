<?php

namespace App\Service\WechatBot\ReceiveMessage\MessageFormat;

interface VideoMessageInterface extends MessageInterface
{
    public function asyncGetMsgVideo();

}