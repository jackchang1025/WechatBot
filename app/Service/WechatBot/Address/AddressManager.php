<?php

namespace App\Service\WechatBot\Address;

use App\Service\ECloud\Config;
use App\Service\ECloud\HttpService;
use App\Service\WechatBot\Exceptions\ApiResponseException;
use App\Service\WechatBot\Exceptions\ConfirmLoginException;
use GuzzleHttp\Exception\GuzzleException;

readonly class AddressManager implements AddressInterface
{
    public function __construct(
        protected HttpService $httpService,
        protected Config $config,
    )
    {
    }

    /**
     * 初始化通讯录列表
     * @return array
     * @throws GuzzleException
     * @throws ApiResponseException|ConfirmLoginException
     */
    public function initAddressList(): array
    {
        return $this->httpService->post('/initAddressList', [
            'wId' => $this->config->get('wId'),
        ]);
    }

    /**
     * 获取通讯录列表
     * @return AddressListInterface
     * @throws ApiResponseException
     * @throws ConfirmLoginException
     * @throws GuzzleException
     */
    public function getAddressList(): AddressListInterface
    {
        //初始化通讯录列表
        $this->initAddressList();

//        return  $this->httpService->post('/getAddressList', [
//            'wId' => $this->config->get('wId'),
//        ]);


    }
}