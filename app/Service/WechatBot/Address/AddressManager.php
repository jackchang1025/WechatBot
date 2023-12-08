<?php

namespace App\Service\WechatBot\Address;

use App\Service\WechatBot\ServiceProviderInterface;
use App\Service\WechatBot\User\UserInterface;

class AddressManager implements AddressManagerInterface
{


    public function __construct(protected UserInterface $user,protected ServiceProviderInterface $serviceProvider)
    {
    }

    public function getAddressList(): AddressListInterface
    {
        $addressList =  $this->serviceProvider->getRemoteAddressManager()->getAddressList();

        $this->user->setAddressList($addressList);

        return $addressList;
    }
}