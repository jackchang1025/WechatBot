<?php

namespace App\Service\ECloud\Login;

use App\Service\WechatBot\Login\QRCodeResponseInterface;

class QRCodeResponse implements QRCodeResponseInterface
{

    public function __construct(protected array $data = [])
    {
    }

    public function getQrCodeUrl(): string
    {
        return $this->data['qrCodeUrl'];
    }
}