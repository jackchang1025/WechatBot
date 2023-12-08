<?php

namespace App\Service\WechatBot\User;

use App\Service\WechatBot\Address\AddressManager;
use App\Service\WechatBot\Address\AddressManagerInterface;
use App\Service\WechatBot\ServiceProviderInterface;
use App\Service\WechatBot\User\Login\LoginManager;
use App\Service\WechatBot\User\Login\LoginManagerInterface;

class UserManager implements UserManagerInterface
{
    protected LoginManagerInterface $loginManager;
    protected AddressManagerInterface $addressManager;

    public function __construct(protected UserInterface $user, protected ServiceProviderInterface $serviceProvider)
    {
        $this->loginManager   = new  LoginManager($user, $serviceProvider);
        $this->addressManager = new  AddressManager($user, $serviceProvider);
    }

    public function getLoginManager(): Login\LoginManagerInterface
    {
        return $this->loginManager;
    }

    public function getUserManager(): UserInterface
    {
        return $this->user;
    }

    public function getAddressManager(): AddressManagerInterface
    {
        return $this->addressManager;
    }
}