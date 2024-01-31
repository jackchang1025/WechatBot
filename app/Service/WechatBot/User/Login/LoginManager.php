<?php

namespace App\Service\WechatBot\User\Login;

use App\Service\WechatBot\Enum\UserStatus;
use App\Service\WechatBot\Login\QRCodeResponseInterface;
use App\Service\WechatBot\RepositoryI\UserRepositoryInterface;
use App\Service\WechatBot\User\Account;
use App\Service\WechatBot\User\UserInterface;
use Exception;

trait LoginManager
{

    /**
     * @return QRCodeResponseInterface
     * @throws Exception
     */
    public function getQRCode(): QRCodeResponseInterface
    {
        $response = $this->serviceProvider->getQRCode();

        if (!$response->getQrCodeUrl()) {
            throw new Exception("获取二维码失败");
        }

        if (!$response->getInstanceId()) {
            throw new Exception("获取实例id失败");
        }



        return $response;
    }

    public function getUserInfo(): UserResponseInterface
    {
        //获取用户信息
        return $this->serviceProvider->getUserInfo();
    }
}