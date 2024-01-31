<?php

namespace App\Service\WechatBot\User;

class Account {

    public function __construct(protected array $data = [])
    {
    }

    /**
     * 微信原始id
     * @return string
     */
    public function getWechatId(): string
    {
        return $this->data['wcId'] ?? '';
    }

    public function getNickName(): string
    {
        return $this->data['nickName']?? '';
    }

    public function getDeviceType(): string
    {
        return $this->data['deviceType']?? '';
    }

    public function getUin(): int
    {
        return $this->data['uin']?? '';
    }

    public function getHeadUrl(): string
    {
        return $this->data['headUrl']?? '';
    }

    public function getWAccount(): string
    {
        return $this->data['wAccount']?? '';
    }

    public function getSex(): int
    {
        return $this->data['sex']?? '';
    }

    public function getMobilePhone(): string
    {
        return $this->data['mobilePhone']?? '';
    }

    public function getStatus(): string
    {
        return $this->data['status']?? '';
    }
}
