<?php

namespace App\Service\WechatBot\SendMessage\MessageFormat;

class Image implements ImageInterface
{
    public function __construct(protected string $url)
    {
    }

    public function url(): string
    {
        return $this->url;
    }
}