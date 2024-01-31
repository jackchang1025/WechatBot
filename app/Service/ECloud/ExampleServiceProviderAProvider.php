<?php

namespace App\Service\ECloud;

use App\Service\ECloud\Config\Config;
use App\Service\ECloud\Config\ConfigInterface;
use App\Service\OneBotECloud\HttpService\TraitAccessToken;
use App\Service\OneBotECloud\HttpService\TraitAddress;
use App\Service\OneBotECloud\HttpService\TraitHttpClient;
use App\Service\OneBotECloud\HttpService\TraitLogin;
use App\Service\ECloud\Message\RemoteReceiveMessageHandle;
use App\Service\WechatBot\Exceptions\AccountStatusException;
use App\Service\WechatBot\Exceptions\ConfigException;
use App\Service\WechatBot\ReceiveMessage\MessageFormat\MessageInterface;
use App\Service\WechatBot\ReceiveMessage\RemoteReceiveMessageHandleInterface;
use App\Service\WechatBot\ServiceProviderInterface;
use Illuminate\Http\Request;
use Psr\Http\Message\ResponseInterface;

class ExampleServiceProviderAProvider implements ServiceProviderInterface
{

    use TraitLogin;
//    use TraitAccessToken;
//    use TraitAddress;
    use TraitHttpClient;

    protected ConfigInterface $config;
    protected Request $request;
    protected RemoteReceiveMessageHandleInterface $remoteReceiveMessageHandle;

    /**
     *
     * @throws ConfigException|AccountStatusException
     */
    public function __construct(array $config)
    {
//        if (empty($options['account'])) {
//            throw new ConfigException('account is empty');
//        }
//
//        if (empty($options['password'])) {
//            throw new ConfigException('password is empty');
//        }
//
//        if (empty($options['base_uri'])) {
//            throw new ConfigException('base_uri is empty');
//        }
//        if (empty($options['Authorization'])) {
//            $this->setAccessToken($options['Authorization']);
//        }

//        $this->request                    = Request::createFromGlobals();
//        $this->config                     = new Config($config);
//        $this->remoteReceiveMessageHandle = new RemoteReceiveMessageHandle();
//
//        $this->getHttpClient()->withRequestMiddleware(fn($request) => var_dump((string)$request->getUri()));
//        $this->getHttpClient()->withToken($this->getAccessToken(), 'Authorization');
    }

    public function getMessage(): MessageInterface
    {
        $message = $this->request->all();

        return $this->remoteReceiveMessageHandle->dataToMessageFormat($message);
    }

    public function getRemoteReceiveMessageHandle(): RemoteReceiveMessageHandleInterface
    {
        return $this->remoteReceiveMessageHandle;
    }

    public function setInstanceId(string $instanceId): void
    {
        $this->config->set('instanceId', $instanceId);
    }

    public function setWechatId(string $wechatId): void
    {
        $this->config->set('wechatId', $wechatId);
    }

    public function getInstanceId(): string
    {
        return $this->config->get('instanceId');
    }

    public function getWechatId(): string
    {
        return $this->config->get('wechatId');
    }

    public function getConfig(): ConfigInterface
    {
        return $this->config;
    }
}