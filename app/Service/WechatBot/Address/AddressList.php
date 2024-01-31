<?php

namespace App\Service\WechatBot\Address;

use App\Service\WechatBot\Friend\FriendInterface;
use App\Service\WechatBot\Friend\Friend;

class AddressList implements AddressListInterface
{
    public function __construct(protected array $addressList)
    {
    }

    public function getAddressList()
    {
        return $this->addressList;
    }

    public function getAddress(int $wechatId): ?FriendInterface
    {
        //
    }
}