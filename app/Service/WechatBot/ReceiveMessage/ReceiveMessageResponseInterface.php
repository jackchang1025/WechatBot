<?php

namespace App\Service\WechatBot\ReceiveMessage;

interface ReceiveMessageResponseInterface
{
    public function getMessageType();
}