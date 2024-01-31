<?php

namespace App\Service\ECloud\Login;

use App\Service\WechatBot\Response;
use App\Service\WechatBot\User\Login\UserResponseInterface;

class UserResponse extends Response implements UserResponseInterface
{
    public function getWechatId(): string
    {
        return $this->response->object()->wcId;
    }

    public function getNickName(): string
    {
        return $this->response->object()->nickName;
    }

    public function getDeviceType(): string
    {
        return $this->response->object()->deviceType;
    }

    public function getHeadUrl(): string
    {
        return $this->response->object()->headUrl;
    }

    public function getSex(): int
    {
        return $this->response->object()->sex;
    }

    public function getPhone(): string
    {
        return $this->response->object()->mobilePhone;
    }
}