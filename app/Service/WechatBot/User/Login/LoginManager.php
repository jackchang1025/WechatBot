<?php

namespace App\Service\WechatBot\User\Login;

use App\Service\WechatBot\Enum\UserStatus;
use App\Service\WechatBot\Login\QRCodeResponseInterface;
use App\Service\WechatBot\ServiceProviderInterface;
use App\Service\WechatBot\User\UserInterface;
use Exception;

class LoginManager implements LoginManagerInterface
{

    public function __construct(protected UserInterface $user, protected ServiceProviderInterface $serviceProvider)
    {

    }

    public function login(): UserInterface
    {
        //登录
        $this->serviceProvider->getRemoteLoginManager()->login();

        return $this->user;
    }

    /**
     * @return QRCodeResponseInterface
     * @throws Exception
     */
    public function getQRCode(): QRCodeResponseInterface
    {
        $response = $this->serviceProvider->getRemoteLoginManager()->getQRCode();

        if (!$response->getQrCodeUrl()) {
            throw new Exception("获取二维码失败");
        }

        return $response;
    }

    public function getUserInfo(): UserInterface
    {
        //获取用户信息
        $data =  $this->serviceProvider->getRemoteLoginManager()->getUserInfo();

        $this->user->setData($data);
        $this->user->setStatus(UserStatus::LOGIN->value);

        return $this->user;
    }
}