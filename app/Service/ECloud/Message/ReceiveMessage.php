<?php

namespace App\Service\ECloud\Message;

use App\Service\ECloud\ConfigTrait;
use App\Service\OneBotECloud\HttpService\TraitHttpClient;
use App\Service\WechatBot\Exceptions\ApiResponseException;
use App\Service\WechatBot\Exceptions\ConfirmLoginException;
use GuzzleHttp\Exception\GuzzleException;

class ReceiveMessage implements \App\Service\WechatBot\ReceiveMessage\ReceiveMessageInterface
{

    public function __construct(
        protected TraitHttpClient $httpService,
        protected ConfigTrait $config,
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