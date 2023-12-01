<?php

namespace App\Service\WechatBot;

use App\Service\ECloud\Config;
use App\Service\WechatBot\Address\AddressInterface;
use App\Service\WechatBot\Friend\FriendInterface;
use App\Service\WechatBot\Login\LoginManagerInterface;
use App\Service\WechatBot\ReceiveMessage\ReceiveMessageHandleInterface;
use App\Service\WechatBot\SendMessage\SendMessageManagerInterface;

interface ServiceProviderInterface
{
    public function getLoginManager(): LoginManagerInterface;

    public function getFriendsManager(): FriendManagerInterface;

    public function getAddressManager(): AddressManagerInterface;

    public function getReceiveMessageHandle():ReceiveMessageHandleInterface;

    public function getMomentsManager():MomentsManagerInterface;

    public function getConfig():Config;

    public function getSendMessageManager():SendMessageManagerInterface;

    // 可以添加更多方法，如处理事件、发送图片等
}
