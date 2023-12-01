<?php

namespace App\Service\WechatBot\Login;
interface QRCodeResponseInterface
{
    public function getQrCodeUrl():string;
}