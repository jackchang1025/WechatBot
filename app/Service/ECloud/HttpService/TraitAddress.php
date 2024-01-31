<?php

namespace App\Service\OneBotECloud\HttpService;

use App\Service\ECloud\Config\ConfigInterface;
use App\Service\OneBotECloud\HttpService\TraitHttpClient;
use App\Service\WechatBot\Address\AddressList;
use App\Service\WechatBot\Address\AddressListInterface;
use App\Service\WechatBot\Address\RemoteAddressManagerInterface;
use App\Service\WechatBot\Exceptions\ApiResponseException;
use App\Service\WechatBot\Exceptions\ConfirmLoginException;
use GuzzleHttp\Exception\GuzzleException;

trait TraitAddress
{
    protected bool $isAddressListInit = false;

    /**
     * 获取通讯录列表
     * @return AddressListInterface
     */
    public function getAddressList(): AddressListInterface
    {
        //初始化通讯录列表
        if (!$this->isAddressListInit()) {
            $this->initAddressList();
        }

        $response = $this->post('/getAddressList', [
            'wId' => $this->config->get('wId'),
        ]);

        return $this->parseAddressListResponse($response);
    }

    public function isAddressListInit(): bool
    {
        return $this->isAddressListInit;
    }

    public function setIsAddressListInit(bool $isAddressListInit): void
    {
        $this->isAddressListInit = $isAddressListInit;
    }

    /**
     * 初始化通讯录列表
     * @return array
     */
    public function initAddressList(): array
    {
        $this->setAccessToken(true);

        return $this->post('/initAddressList', [
            'wId' => $this->config->get('wId'),
        ]);
    }

    private function parseAddressListResponse($response): AddressListInterface
    {
        return new AddressList($response);
    }
}