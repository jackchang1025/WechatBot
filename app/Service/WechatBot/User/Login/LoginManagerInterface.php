<?php

namespace App\Service\WechatBot\User\Login;

use App\Service\WechatBot\Login\QRCodeResponseInterface;
use App\Service\WechatBot\User\UserInterface;

interface LoginManagerInterface
{
    public function login(): UserInterface;

    public function getQRCode(): QRCodeResponseInterface;
}