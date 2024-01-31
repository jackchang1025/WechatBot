<?php

namespace App\Service\Adapter;

use App\Service\OneBot\Event\OneBotEvent;

interface AdapterInterface
{
    /**
     *  格式化消息为 onebot 格式
     * @param array $data
     * @return OneBotEvent
     */
    public function formatRemoteServiceOneBot(array $data):OneBotEvent;

    /**
     *  处理 http 请求
     * @param $request
     * @param $response
     * @return void
     */
    public function onRequest($request, $response):void;

    /**
     *  处理 websocket 消息
     * @return mixed
     */
    public function onMessage();

    /**
     *   处理 websocket 关闭
     * @return mixed
     */
    public function onClose();
}