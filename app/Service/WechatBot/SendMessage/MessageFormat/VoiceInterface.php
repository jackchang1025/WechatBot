<?php

namespace App\Service\WechatBot\SendMessage\MessageFormat;

interface VoiceInterface
{
    public function getContent(): string;
    public function length(): int;
}