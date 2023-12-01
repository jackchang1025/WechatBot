<?php

namespace App\Service\WechatBot\Middleware;

use App\Service\WechatBot\ReceiveMessage\MessageFormat\ImageMessageInterface;
use App\Service\WechatBot\ReceiveMessage\MessageFormat\MessageInterface;
use App\Service\WechatBot\ReceiveMessage\MessageFormat\PrivateChat\PrivateChatMessageInterface;
use App\Service\WechatBot\SendMessage\MessageFormat\Image;

class ImageMessageMiddleware implements MiddlewareInterface
{

    public function handle(MessageInterface $request, \Closure $next)
    {

        if($request instanceof ImageMessageInterface){

            var_dump('ImageMessageMiddleware',$request->getImg());

            if ($request instanceof PrivateChatMessageInterface) {

                $toUser = $request->toUser();

                $toUser->sendImage($request->toFromUser(), new Image('https://www.baidu.com'));
            }
        }

        return $next($request);
    }
}