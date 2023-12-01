<?php

namespace App\Service\ECloud\MessageFormat;

use App\Service\WechatBot\ReceiveMessage\MessageFormat\ImageMessageInterface;

class ImageMessage implements ImageMessageInterface
{
    use Message;

    public function getImg(): string
    {
        return $this->options['data']['img']?? '';
    }

    public function downloadImage(){

    }
}