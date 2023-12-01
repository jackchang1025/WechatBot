<?php

namespace App\Service\WechatBot\SendMessage\MessageFormat;

interface TextInterface
{
    public function getContent(): string;
}