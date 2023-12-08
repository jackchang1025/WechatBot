<?php

namespace App\Service\ECloud\MessageFormat;

use App\Service\WechatBot\Friend\FriendInterface;
use App\Service\WechatBot\Group\GroupInterface;
use App\Service\WechatBot\ReceiveMessage\MessageFormat\ImageMessageInterface;
use App\Service\WechatBot\User\UserInterface;

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