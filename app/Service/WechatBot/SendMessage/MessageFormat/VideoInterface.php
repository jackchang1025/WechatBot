<?php

namespace App\Service\WechatBot\SendMessage\MessageFormat;

interface VideoInterface
{
    public function path(): string;

    public function thumbPath(): string;
}