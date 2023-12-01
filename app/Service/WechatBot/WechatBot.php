<?php

namespace App\Service\WechatBot;


use App\Service\WechatBot\Exceptions\ApiResponseException;
use App\Service\WechatBot\Exceptions\ConfirmLoginException;
use App\Service\WechatBot\Login\LoginHandleInterface;
use App\Service\WechatBot\Middleware\Middleware;
use App\Service\WechatBot\User\User;
use App\Service\WechatBot\User\UserInterface;

readonly class WechatBot
{
    protected UserInterface $user;

    public function __construct(
        protected ServiceProviderInterface $serviceProvider,
        protected LoginHandleInterface $loginHandle,
        protected Middleware $middleware,
    ) {
        // 初始化
        $this->initialize();
    }

    // 初始化函数
    private function initialize()
    {
        // 这里可以添加代码来初始化设置日志等
    }

    public function getServiceProvider(): ServiceProviderInterface
    {
        return $this->serviceProvider;
    }

    public function start()
    {
        //获取二维码
        echo $this->getQRCode();

        // 获取用户信息
        $this->user = new User($this->serviceProvider->getLoginManager()->getUserInfo(),$this->serviceProvider);

        var_dump($this->user);

        //获取通讯录列表
        $addressList = $this->serviceProvider->getAddressManager()->getAddressList();

        $this->user->setAddressList($addressList);

        // TODO: 使用异步任务获取联系人信息异步任务
    }

    /**
     * @return mixed
     * @throws ApiResponseException
     * @throws ConfirmLoginException|\Exception
     */
    public function getQRCode(): mixed
    {
        $response = $this->serviceProvider->getLoginManager()->getQRCode();

        if (!$response->getQrCodeUrl()) {
            throw new \Exception("获取二维码失败");
        }

        return $this->loginHandle->qRCodeUrlHandle($response);
    }

    // 接收消息
    private function receiveMessage()
    {

    }

    public function receiveMessageHandle(array $data){

        $message = $this->serviceProvider->getReceiveMessageHandle()->dataToMessageFormat($data);

        return $this->middleware->setData($message)->handle();
    }

    // 其他可能的方法，例如发送消息、处理事件等
    public function sendMessage($message)
    {
        // 实现发送消息的逻辑
    }
}
