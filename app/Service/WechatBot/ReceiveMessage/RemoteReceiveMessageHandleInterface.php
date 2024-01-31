<?php

namespace App\Service\WechatBot\ReceiveMessage;

use App\Service\WechatBot\ReceiveMessage\MessageFormat\MessageInterface;
use App\Service\WechatBot\User\UserInterface;

interface RemoteReceiveMessageHandleInterface
{
    public function receiveMessageHandle(ReceiveMessageResponseInterface $receiveMessageResponse);

    public function dataToMessageFormat(array $data):MessageInterface;
}