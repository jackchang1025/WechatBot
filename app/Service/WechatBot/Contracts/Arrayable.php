<?php

declare(strict_types=1);

namespace App\Service\WechatBot\Contracts;

interface Arrayable
{
    /**
     * @return array<int|string, mixed>
     */
    public function toArray(): array;
}
