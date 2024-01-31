<?php

namespace App\Service\ECloud\Login;

use App\Service\WechatBot\Login\QRCodeResponseInterface;
use App\Service\WechatBot\Response;

class QRCodeResponse extends Response implements QRCodeResponseInterface
{
    public function getQrCodeUrl(): ?string
    {
        return $this->response->object()->qrCodeUrl;
    }

    public function getInstanceId(): ?string
    {
        return $this->response->object()->wId;
    }
}