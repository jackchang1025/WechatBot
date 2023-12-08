<?php

namespace App\Service\WechatBot;

use App\Event\LoginQRCodeEvent;
use App\Event\receiveMessageEvent;
use App\Event\UserInitEvent;
use App\Service\ECloud\ExampleServiceProviderAProvider;
use App\Service\WechatBot\User\UserManagerInterface;
use Hyperf\Context\ApplicationContext;
use Psr\EventDispatcher\EventDispatcherInterface;
use Swoole\Coroutine\Http\Server;
use Swoole\Http\Request;
use Swoole\Http\Response;

 class WechatBot implements WechatBotInterface
{

    public function __construct(
        protected UserManagerInterface $userManager,
        protected ServiceProviderInterface $serviceProvider,
    ) {
    }

    public function start()
    {
        $user = $this->userManager->getUserManager();

        if (!$user->isLogin()) {

            //登录
            $this->userManager->getLoginManager()->login();

            //获取二维码
            $response = $this->userManager->getLoginManager()->getQRCode();
            ApplicationContext::getContainer()->get(EventDispatcherInterface::class)->dispatch(new LoginQRCodeEvent($response));

            //获取用户信息
            $user = $this->userManager->getLoginManager()->getUserInfo();
            ApplicationContext::getContainer()->get(EventDispatcherInterface::class)->dispatch(new UserInitEvent($user));
        }

        //获取通讯录列表
//        $addressList = $this->userManager->getAddressManager()->getAddressList();

//        var_dump($addressList->getAddressList());

    }

    public function getUserManager(): UserManagerInterface
    {
        return $this->userManager;
    }

    public function receiveMessageHandle(array $data): void
    {
        $message = $this->serviceProvider->getRemoteReceiveMessageHandle()->dataToMessageFormat(
            $data,
            $this->getUserManager()->getUserManager()
        );
        ApplicationContext::getContainer()->get(EventDispatcherInterface::class)->dispatch(
            new ReceiveMessageEvent($message)
        );
//
//        return $this->middleware->setData($message)->handle();
    }
}
