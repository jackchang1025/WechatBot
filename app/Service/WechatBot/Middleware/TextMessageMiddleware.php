<?php

namespace App\Service\WechatBot\Middleware;

use App\Service\WechatBot\ReceiveMessage\MessageFormat\MessageInterface;
use App\Service\WechatBot\ReceiveMessage\MessageFormat\PrivateChat\PrivateChatMessageInterface;
use App\Service\WechatBot\ReceiveMessage\MessageFormat\TextMessageInterface;
use App\Service\WechatBot\SendMessage\MessageFormat\Text;

class TextMessageMiddleware implements MiddlewareInterface
{

    public function handle(MessageInterface $request, \Closure $next)
    {

        if ($request instanceof TextMessageInterface) {

            var_dump('TextMessageMiddleware', $request->getContent());

            if ($request instanceof PrivateChatMessageInterface) {
                $toUser = $request->toUser();
                $toUser->send($request->toFromUser(), new Text($request->getContent()));
            }

        }

        return $next($request);
    }
}