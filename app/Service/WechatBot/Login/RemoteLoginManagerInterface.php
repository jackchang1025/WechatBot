<?php

namespace App\Service\WechatBot\Login;

use App\Service\ECloud\Login\LoginResponse;
use App\Service\WechatBot\User\UserInterface;

interface RemoteLoginManagerInterface
{
    public function  login();

    public function getQRCode(): QRCodeResponseInterface;

    public function getUserInfo(): array;
}