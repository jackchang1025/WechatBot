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

            //获取消息发送给当前用户
            $toUser = $request->toUser();
            //获取消息发送者
            $toFromUser = $request->toFromUser();
            //回复一个文本消息
            $toUser->send($toFromUser, new Text($request->getContent()));
        }

        return $next($request);
    }
}