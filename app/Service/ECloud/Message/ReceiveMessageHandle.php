<?php

namespace App\Service\ECloud\Message;

use App\Service\ECloud\Enum\MessageType;
use App\Service\ECloud\MessageFormat\ImageMessage;
use App\Service\WechatBot\ReceiveMessage\MessageFormat\MessageInterface;
use App\Service\WechatBot\ReceiveMessage\ReceiveMessageHandleInterface;
use App\Service\WechatBot\ReceiveMessage\ReceiveMessageResponseInterface;
use App\Service\ECloud\MessageFormat\TextMessage;

class ReceiveMessageHandle implements ReceiveMessageHandleInterface
{

    public function receiveMessageHandle(ReceiveMessageResponseInterface $receiveMessageResponse)
    {

    }

    /**
     * @throws \Exception
     */
    public function dataToMessageFormat(array $data): MessageInterface
    {

        return match ($data['messageType']) {
            MessageType::Text->value => new TextMessage($data),
            MessageType::Image->value => new ImageMessage($data),
//            MessageType::Video->value => new TextMessage($data),
            default => throw new \Exception('暂不支持该消息类型'),
        };
    }
}