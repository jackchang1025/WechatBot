<?php

namespace App\Service\ECloud\Login;

use App\Service\ECloud\Config;
use App\Service\ECloud\Enum\AccountStatus;
use App\Service\ECloud\HttpService;
use App\Service\WechatBot\Exceptions\AccountStatusException;
use App\Service\WechatBot\Exceptions\ApiResponseException;
use App\Service\WechatBot\Exceptions\ConfirmLoginException;
use App\Service\WechatBot\Login\RemoteLoginManagerInterface;
use App\Service\WechatBot\Login\QRCodeResponseInterface;
use GuzzleHttp\Exception\GuzzleException;

readonly class RemoteLoginManager implements RemoteLoginManagerInterface
{
    /**
     * @param HttpService $httpService
     * @param Config $config
     */
    public function __construct(protected HttpService $httpService, protected Config $config)
    {
    }

    /**
     * 初始化登录
     * @return array
     * @throws AccountStatusException
     * @throws GuzzleException|ApiResponseException|ConfirmLoginException
     */
    public function login(): array
    {
        $response = $this->httpService->post('/member/login', [
            'account'  => $this->config->get('account'),
            'password' => $this->config->get('password'),
        ]);

        if ($response['status'] != AccountStatus::NORMAL->value) {
            $status = AccountStatus::from($response['status']);
            throw new AccountStatusException($status->getDescription());
        }

        // 登录成功逻辑
        $this->config->set('Authorization', $response['Authorization']);
        $this->config->set('callbackUrl', $response['callbackUrl']);
        $this->config->set('status', $response['status']);

        return $response;
    }

    /**
     * 获取二维码
     * @return QRCodeResponseInterface
     * @throws ApiResponseException
     * @throws ConfirmLoginException
     * @throws GuzzleException
     */
    public function getQRCode(): QRCodeResponseInterface
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
     * @return array
     * @throws ApiResponseException
     * @throws ConfirmLoginException
     * @throws GuzzleException
     */
    public function getUserInfo(): array
    {
        try {
            $response = $this->getIPadLoginInfo();
        } catch (ConfirmLoginException $e) {
            $response = $this->getIPadLoginInfo($e->getVerifyCode());

            $this->config->set('wcId',$response['wcId']);
        }

        return $response;
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
