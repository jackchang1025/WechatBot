<?php

namespace App\Service\WechatBot\Login;

use App\Service\ECloud\Login\LoginResponse;
use App\Service\WechatBot\ResponseInterface;
use App\Service\WechatBot\User\Login\UserResponseInterface;
use App\Service\WechatBot\User\UserInterface;

interface RemoteLoginManagerInterface
{
    public function getQRCode(string $wechatId = ''): ResponseInterface;

    public function getUserInfo(): ResponseInterface;
}