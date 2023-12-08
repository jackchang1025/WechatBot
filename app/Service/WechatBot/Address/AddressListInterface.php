<?php


namespace App\Service\WechatBot\Address;

use App\Service\WechatBot\Friend\FriendInterface;
use App\Service\WechatBot\Friend\Friends;

interface AddressListInterface
{
    public function getAddressList();

    public function getAddress(int $wechatId): ?FriendInterface;
}