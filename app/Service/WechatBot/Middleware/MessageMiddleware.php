<?php

namespace App\Service\WechatBot\Middleware;

use App\Service\WechatBot\ReceiveMessage\MessageFormat\MessageInterface;

class MessageMiddleware implements MiddlewareInterface
{

    public function handle(MessageInterface $request, \Closure $next)
    {
        //TODO: Implement handle() method.

//        var_dump('MessageMiddleware',$request->getContent());
//        var_dump($request->getOptions());
        return $next($request);
    }
}