<?php

namespace App\Service\ECloud\Login;

class LoginResponse implements \App\Service\WechatBot\Login\LoginResponseInterface
{

    public function __construct(protected string $qrCodeUrl)
    {
    }

    public function getQrCodeUrl(): string
    {
        return $this->qrCodeUrl;
    }
}