<?php

namespace App\Service\WechatBot\Login;


interface LoginHandleInterface
{
    public function qRCodeUrlHandle(QRCodeResponseInterface $response);
}