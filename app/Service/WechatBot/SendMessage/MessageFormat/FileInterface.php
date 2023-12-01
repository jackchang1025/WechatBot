<?php

namespace App\Service\WechatBot\SendMessage\MessageFormat;

interface FileInterface
{
    public function path(): string;
    public function fileName(): string;
}