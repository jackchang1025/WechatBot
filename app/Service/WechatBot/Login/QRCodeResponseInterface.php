<?php

namespace App\Service\WechatBot\Login;
use App\Service\WechatBot\ResponseInterface;

interface QRCodeResponseInterface extends ResponseInterface
{
    public function getQrCodeUrl():?string;

    public function getInstanceId():?string;
}