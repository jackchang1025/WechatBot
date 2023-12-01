<?php

namespace App\Service\WechatBot\Login;
interface LoginResponseInterface
{
    public function getQrCodeUrl():string;
}