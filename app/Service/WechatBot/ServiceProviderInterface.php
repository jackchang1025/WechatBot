<?php

namespace App\Service\WechatBot;

use App\Service\ECloud\Config;
use App\Service\WechatBot\Address\RemoteAddressManagerInterface;
use App\Service\WechatBot\Friend\RemoteFriendManagerInterface;
use App\Service\WechatBot\Login\RemoteLoginManagerInterface;
use App\Service\WechatBot\ReceiveMessage\RemoteReceiveMessageHandleInterface;
use App\Service\WechatBot\SendMessage\SendMessageManagerInterface;

interface ServiceProviderInterface
{
    public function getRemoteLoginManager(): RemoteLoginManagerInterface;

    public function getRemoteFriendManager(): RemoteFriendManagerInterface;

    public function getRemoteAddressManager(): RemoteAddressManagerInterface;

    public function getRemoteReceiveMessageHandle():RemoteReceiveMessageHandleInterface;

    public function getConfig():Config;

    public function getSendMessageManager():SendMessageManagerInterface;

    // 可以添加更多方法，如处理事件、发送图片等
}
