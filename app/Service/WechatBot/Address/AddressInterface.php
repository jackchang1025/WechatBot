<?php


namespace App\Service\WechatBot\Address;

interface AddressInterface
{
    public function getAddressList() : AddressListInterface;
}