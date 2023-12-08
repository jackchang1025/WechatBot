<?php

namespace App\Service\ECloud\Address;

use App\Service\ECloud\Config;
use App\Service\ECloud\HttpService;
use App\Service\WechatBot\Address\AddressList;
use App\Service\WechatBot\Address\AddressListInterface;
use App\Service\WechatBot\Address\RemoteAddressManagerInterface;
use App\Service\WechatBot\Exceptions\ApiResponseException;
use App\Service\WechatBot\Exceptions\ConfirmLoginException;
use App\Service\WechatBot\GroupList\GroupList;
use GuzzleHttp\Exception\GuzzleException;

 class RemoteAddressManager implements RemoteAddressManagerInterface
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

        $response =  $this->httpService->post('/getAddressList', [
            'wId' => $this->config->get('wId'),
        ]);

        return $this->parseAddressListResponse($response);
    }

    private function parseAddressListResponse($response): AddressListInterface
    {
       return new AddressList($response);
    }
}