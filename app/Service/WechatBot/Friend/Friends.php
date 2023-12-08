<?php

namespace App\Service\WechatBot\Friend;

use App\Service\ECloud\HttpService;
use App\Service\WechatBot\Exceptions\ApiResponseException;
use App\Service\WechatBot\Exceptions\ConfirmLoginException;
use GuzzleHttp\Exception\GuzzleException;
use InvalidArgumentException;

class Friends implements FriendInterface
{

    public function __construct(protected readonly HttpService $httpService,protected array $data = [])
    {
    }

    /**
     * 获取联系人信息
     * @param string $wcId
     * @param string $wId
     * @return Friends
     * @throws GuzzleException
     * @throws ApiResponseException
     * @throws ConfirmLoginException
     */
    public function getContact(string $wcId,string $wId): static
    {
        if (!$wcId){
            throw new InvalidArgumentException('wcId is empty');
        }

        $response =  $this->httpService->post('http://域名地址/getContact', [
            'wId' => $wId,
            'wcId' => $wcId,
        ]);

        return new Friends($this->httpService,$response);
    }

    public function getUserName(): string
    {
        return $this->data['userName']?? '';
    }

    public function getNickName(): string
    {
        return $this->data['nickName']?? '';
    }

    public function getRemark(): string
    {
        return $this->data['remark']?? '';
    }

    public function getSignature(): string
    {
        return $this->data['signature']?? '';
    }

    public function getSex(): int
    {
        return $this->data['sex']?? '';
    }

    public function getAliasName(): string
    {
        return $this->data['aliasName']?? '';
    }

    public function getCountry(): string
    {
        return $this->data['country']?? '';
    }

    public function getBigHead(): string
    {
        return $this->data['bigHead']?? '';
    }

    public function getSmallHead(): string
    {
        return $this->data['smallHead']?? '';
    }

    public function getLabelList(): array
    {
        return $this->data['labelList']?? [];
    }

    public function getWechatId(): string
    {
        return $this->data['v1']?? '';
    }
}