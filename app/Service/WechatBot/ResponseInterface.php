<?php

namespace App\Service\WechatBot;

use App\Service\WechatBot\Contracts\Arrayable;
use App\Service\WechatBot\Contracts\Jsonable;
use ArrayAccess;

interface ResponseInterface
{

    public function toArray():array;
    public function toObject():object;
}