<?php

namespace App\Service\WechatBot\Middleware;

use App\Service\WechatBot\ReceiveMessage\MessageFormat\MessageInterface;

interface MiddlewareInterface
{
    public function handle(MessageInterface $request, \Closure $next);
}