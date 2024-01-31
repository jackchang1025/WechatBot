<?php

namespace App\Service\ECloud\Message;

use App\Service\ECloud\Enum\MessageType;
use App\Service\ECloud\MessageFormat\ImageMessage;
use App\Service\WechatBot\ReceiveMessage\MessageFormat\MessageInterface;
use App\Service\WechatBot\ReceiveMessage\RemoteReceiveMessageHandleInterface;
use App\Service\WechatBot\ReceiveMessage\ReceiveMessageResponseInterface;
use App\Service\ECloud\MessageFormat\TextMessage;
use App\Service\WechatBot\User\UserInterface;

class RemoteReceiveMessageHandle implements RemoteReceiveMessageHandleInterface
{

    public function receiveMessageHandle(ReceiveMessageResponseInterface $receiveMessageResponse)
    {

    }

    /**
     * @param array $data
     * @return ImageMessage|MessageInterface|TextMessage
     * @throws \Exception
     */
    public function dataToMessageFormat(array $data): ImageMessage|MessageInterface|TextMessage
    {
        return match ($data['messageType']) {
            MessageType::Text->value => new TextMessage($data),
            MessageType::Image->value => new ImageMessage($data),
//            MessageType::Video->value => new TextMessage($data),
            default => throw new \Exception('暂不支持该消息类型'),
        };
    }
}