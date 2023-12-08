<?php

namespace App\Service;

use App\Service\ECloud\ExampleServiceProviderAProvider;
use App\Service\ECloud\Login\LoginHandle;
use App\Service\WechatBot\Middleware\ImageMessageMiddleware;
use App\Service\WechatBot\Middleware\MessageMiddleware;
use App\Service\WechatBot\Middleware\Middleware;
use App\Service\WechatBot\Middleware\TextMessageMiddleware;
use App\Service\WechatBot\ServiceProviderInterface;
use App\Service\WechatBot\User\User;
use App\Service\WechatBot\User\UserInterface;
use App\Service\WechatBot\User\UserManager;
use App\Service\WechatBot\User\UserManagerInterface;
use App\Service\WechatBot\WechatBot;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Contract\ContainerInterface;

class WechatBotFactory
{
    protected ServiceProviderInterface $serviceProvider;
    protected UserManagerInterface $userManager;

    protected ContainerInterface $container;

    // 实现一个 __invoke() 方法来完成对象的生产，方法参数会自动注入一个当前的容器实例和一个参数数组
    public function __invoke(ContainerInterface $container, array $parameters = [])
    {
        $this->container = $container;

        $config = $container->get(ConfigInterface::class);

        $exampleServiceProviderAProvider = new ExampleServiceProviderAProvider($config->get('wechat.stores.ecloud'));

        $user = new User([], $exampleServiceProviderAProvider);

        return $this->setServiceProviderAProvider($exampleServiceProviderAProvider)
            ->setUserManager($user)
            ->make();
    }

    public function make()
    {
        return make(WechatBot::class, [
            'container' => $this->container,
            'userManager' => $this->userManager,
            'serviceProvider' => $this->serviceProvider,
        ]);
    }

    public function setUserManager(UserInterface $user): static
    {
        $this->userManager = new UserManager($user, $this->serviceProvider);

        return $this;
    }

    public function setServiceProviderAProvider(ServiceProviderInterface $serviceProvider): static
    {
        $this->serviceProvider = $serviceProvider;

        return $this;
    }
}