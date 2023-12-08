<?php

namespace App\Service\WechatBot\User;

use App\Service\WechatBot\Address\AddressManagerInterface;
use App\Service\WechatBot\User\Login\LoginManagerInterface;

interface UserManagerInterface
{
    public function getLoginManager(): LoginManagerInterface;
    public function getUserManager(): UserInterface;

    public function getAddressManager(): AddressManagerInterface;
}