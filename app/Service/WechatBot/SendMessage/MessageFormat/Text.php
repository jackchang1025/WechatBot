<?php

namespace App\Service\WechatBot\SendMessage\MessageFormat;

class Text implements TextInterface
{

    public function __construct(protected  string $text)
    {
    }

    public function getContent(): string
    {
        return $this->text;
    }
}