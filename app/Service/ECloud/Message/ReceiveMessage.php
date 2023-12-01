<?php

namespace App\Service\ECloud\Message;

use App\Service\ECloud\Config;
use App\Service\ECloud\HttpService;
use App\Service\WechatBot\Exceptions\ApiResponseException;
use App\Service\WechatBot\Exceptions\ConfirmLoginException;
use GuzzleHttp\Exception\GuzzleException;

class ReceiveMessage implements \App\Service\WechatBot\ReceiveMessage\ReceiveMessageInterface
{

    public function __construct(
        protected HttpService $httpService,
        protected Config $config,
    ) {}

    /**
     * 设置消息接收地址
     * @return array
     * @throws GuzzleException
     * @throws ApiResponseException
     * @throws ConfirmLoginException
     */
    public function setHttpCallbackUrl(): array
    {
        return $this->httpService->post('http://域名地址/setHttpCallbackUrl',[
            'httpUrl'=>$this->config->get('http_callback_url'),
            'type'=>2
        ]);
    }

    /**
     * 取消消息接收
     * @return array
     * @throws GuzzleException
     * @throws ApiResponseException
     * @throws ConfirmLoginException
     */
    public function cancelHttpCallbackUrl(): array
    {
        return $this->httpService->post('http://域名地址/cancelHttpCallbackUrl');
    }
}