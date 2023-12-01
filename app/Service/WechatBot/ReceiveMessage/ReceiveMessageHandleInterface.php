<?php

namespace App\Service\WechatBot\ReceiveMessage;

use App\Service\WechatBot\ReceiveMessage\MessageFormat\MessageInterface;

interface ReceiveMessageHandleInterface
{
    public function receiveMessageHandle(ReceiveMessageResponseInterface $receiveMessageResponse);

    public function dataToMessageFormat(array $data):MessageInterface;
}