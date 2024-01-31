<?php

declare(strict_types=1);

namespace App\Service\WechatBot\Contracts;

interface Jsonable
{
    public function toJson(): string|false;
}
