<?php

namespace App\Service;

use App\Service\ECloud\ExampleServiceProviderAProvider;
use App\Service\WechatBot\ServiceProviderInterface;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Contract\ContainerInterface;

class ServiceProviderInterfaceFactory
{
    /**
     * @param ContainerInterface $container
     * @param array $parameters
     * @return ServiceProviderInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, array $parameters = []): ServiceProviderInterface
    {
        $config = $container->get(ConfigInterface::class)->get('wechat.stores.ecloud');
        return new ExampleServiceProviderAProvider($config);
    }
}