<?php

namespace App\Service\WechatBot\Address;

interface RemoteAddressManagerInterface
{
    public function getAddressList():AddressListInterface;
}