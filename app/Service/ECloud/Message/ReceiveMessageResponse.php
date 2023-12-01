<?php

namespace App\Service\ECloud\Message;

use App\Service\WechatBot\ReceiveMessage\ReceiveMessageResponseInterface;

readonly class ReceiveMessageResponse implements ReceiveMessageResponseInterface
{

    public function __construct(protected array $data)
    {
    }

    public function getMessageType()
    {
        // TODO: Implement getMessageType() method.
    }
}