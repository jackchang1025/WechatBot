<?php

namespace App\Service\OneBotECloud\HttpService;

use App\Service\ECloud\Login\QRCodeResponse;
use App\Service\ECloud\Login\UserResponse;
use App\Service\WechatBot\Exceptions\ApiResponseException;
use App\Service\WechatBot\Exceptions\ConfirmLoginException;
use App\Service\WechatBot\Exceptions\RetryableException;
use App\Service\WechatBot\Login\QRCodeResponseInterface;
use App\Service\WechatBot\User\Login\UserResponseInterface;
use Illuminate\Http\Client\Response;


trait TraitLogin
{

    protected string $verifyCode = '';

    /**
     * 获取二维码
     * @return QRCodeResponseInterface
     * @throws ApiResponseException
     */
    public function getQRCode(): QRCodeResponseInterface
    {
        $response = $this->getHttpClient()->post('/iPadLogin', [
            'wcId'          => $this->getWechatId(),
            'proxy'         => $this->config->get('proxy'),
            'proxyIp'       => $this->config->get('proxyIp'),
            'proxyUser'     => $this->config->get('proxyUser'),
            'proxyPassword' => $this->config->get('proxyPassword'),
        ]);

        if (empty($response->qrCodeUrl)) {
            throw new ApiResponseException('获取二维码失败');
        }

        if (empty($response->wId)) {
            throw new ApiResponseException('获取 wId 失败');
        }

        return new QRCodeResponse($response);
    }

    /**
     * @return UserResponseInterface
     * @throws RetryableException
     * @throws \Throwable
     */
    public function getUserInfo(): UserResponseInterface
    {
        $response = $this->getHttpClient()
            ->setResponseMiddleware(function (Response $response, $next) {

                if ($response->object()->message === "请在ipad上输入验证码") {
                    $this->setVerifyCode($response->object()->verifyCode);

                    throw  new RetryableException();
                }

                return $next($response);
            })
            ->retry(3,100)
            ->post('/getIPadLoginInfo', [
                'wId'        => $this->getInstanceId(),
                'verifyCode' => $this->getVerifyCode(),
            ]);

        return new UserResponse($response);
    }

    public function getVerifyCode(): string
    {
        return $this->verifyCode;
    }

    public function setVerifyCode(string $verifyCode): void
    {
        $this->verifyCode = $verifyCode;
    }
}
