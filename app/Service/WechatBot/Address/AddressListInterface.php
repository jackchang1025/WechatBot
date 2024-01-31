<?php


namespace App\Service\WechatBot\Address;

use App\Service\WechatBot\Friend\FriendInterface;
use App\Service\WechatBot\Friend\Friend;

interface AddressListInterface
{
    public function getAddressList();

    public function getAddress(int $wechatId): ?FriendInterface;
}