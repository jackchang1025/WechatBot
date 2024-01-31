<?php

namespace App\Service\WechatBot\Event;
use App\Service\WechatBot\Login\QRCodeResponseInterface;

class GetQRCodeEvent
{
    public function __construct(public QRCodeResponseInterface $QRCodeResponse)
    {

    }
}
