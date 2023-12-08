<?php

declare(strict_types=1);

namespace App\Controller\ECloud;

use App\Service\WechatBot\BotManager;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

class CallbackController
{

    public function __construct(protected readonly BotManager $botManager)
    {
    }

    public function index(RequestInterface $request, ResponseInterface $response)
    {
        //接收消息
        $this->botManager->findBotByWcId($request->input('wcid'))->receiveMessageHandle($request->all());
    }
}
