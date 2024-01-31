<?php

namespace App\Service\WechatBot\User\Login;

use App\Service\WechatBot\ResponseInterface;

interface UserResponseInterface extends ResponseInterface
{
    public function getWechatId(): string;

    public function getNickName(): string;

    public function getDeviceType(): string;

    public function getHeadUrl(): string;

    public function getSex(): int;

    public function getPhone(): string;
}