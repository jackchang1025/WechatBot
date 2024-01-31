<?php

namespace App\Service\ECloud\Login;

use App\Service\ECloud\Config\ConfigInterface;
use App\Service\OneBotECloud\HttpService\TraitHttpClient;
use App\Service\WechatBot\Exceptions\AccountStatusException;
use App\Service\WechatBot\Exceptions\ApiResponseException;
use App\Service\WechatBot\Exceptions\ConfirmLoginException;
use App\Service\WechatBot\Login\QRCodeResponseInterface;
use App\Service\WechatBot\Login\RemoteLoginManagerInterface;
use App\Service\WechatBot\User\Login\UserResponseInterface;
use GuzzleHttp\Exception\GuzzleException;

readonly class RemoteLoginManager implements RemoteLoginManagerInterface
{
    /**
     * @param TraitHttpClient $httpService
     * @param ConfigInterface $config
     */
    public function __construct(protected TraitHttpClient $httpService, protected ConfigInterface $config)
    {
    }

    /**
     * 获取二维码
     * @param string $wechatId
     * @return QRCodeResponseInterface
     * @throws ApiResponseException
     * @throws ConfirmLoginException
     * @throws GuzzleException|AccountStatusException
     */
    public function getQRCode(string $wechatId = ''): QRCodeResponseInterface
    {
        $response = $this->httpService->post('/iPadLogin', [
            'wcId'          => $this->config->get('wcId',''),
            'proxy'         => $this->config->get('proxy'),
            'proxyIp'       => $this->config->get('proxyIp'),
            'proxyUser'     => $this->config->get('proxyUser'),
            'proxyPassword' => $this->config->get('proxyPassword'),
        ]);

        if (empty($response['qrCodeUrl'])) {
            throw new ApiResponseException('获取二维码失败');
        }

        if (empty($response['wId'])) {
            throw new ApiResponseException('获取 wId 失败');
        }

        $this->config->set('qrCodeUrl', $response['qrCodeUrl']);
        $this->config->set('wId', $response['wId']);

        return new QRCodeResponse($response);
    }

    /**
     * @return UserResponseInterface
     * @throws ApiResponseException
     * @throws ConfirmLoginException
     * @throws GuzzleException
     */
    public function getUserInfo(): UserResponseInterface
    {
        try {
            $response = $this->getIPadLoginInfo();
        } catch (ConfirmLoginException $e) {
            $response = $this->getIPadLoginInfo($e->getVerifyCode());
        }

        return new UserResponse($response);
    }

    /**
     * 确认登录
     * @param null $verifyCode
     * @return array
     * @throws ApiResponseException
     * @throws ConfirmLoginException
     * @throws GuzzleException
     */
    public function getIPadLoginInfo($verifyCode = null): array
    {
        if (!$this->config->get('wId')){
            throw new ConfirmLoginException('wId 为空请先获取二维码');
        }

        return $this->httpService->post('/getIPadLoginInfo', [
            'wId'        => $this->config->get('wId'),
            'verifyCode' => $verifyCode,
        ]);
    }

}
