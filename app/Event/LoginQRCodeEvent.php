<?php

namespace App\Event;

use App\Service\WechatBot\Login\QRCodeResponseInterface;

class LoginQRCodeEvent
{

    public function __construct(public QRCodeResponseInterface $response)
    {
    }
}