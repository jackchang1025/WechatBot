<?php

namespace App\Service\WechatBot;

use App\Service\ECloud\Config\ConfigInterface;
use App\Service\ECloud\ConfigTrait;
use App\Service\WechatBot\Address\RemoteAddressManagerInterface;
use App\Service\WechatBot\Friend\RemoteFriendManagerInterface;
use App\Service\WechatBot\Login\RemoteLoginManagerInterface;
use App\Service\WechatBot\ReceiveMessage\MessageFormat\MessageInterface;
use App\Service\WechatBot\ReceiveMessage\RemoteReceiveMessageHandleInterface;
use App\Service\WechatBot\SendMessage\SendMessageManagerInterface;

interface ServiceProviderInterface
{
//    public function getQRCode();
//
//    public function getRemoteReceiveMessageHandle(): RemoteReceiveMessageHandleInterface;
//
//    public function getConfig(): ConfigInterface;
//
//    public function getMessage(): MessageInterface;
//
//    public function setInstanceId(string $instanceId);
//
//    public function setWechatId(string $wechatId);
//
//    public function getInstanceId(): string;
//
//    public function getWechatId(): string;

    // 可以添加更多方法，如处理事件、发送图片等
}
