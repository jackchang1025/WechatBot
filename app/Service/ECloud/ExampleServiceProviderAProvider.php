<?php

namespace App\Service\ECloud;

use App\Service\ECloud\Address\RemoteAddressManager;
use App\Service\ECloud\Friends\RemoteFriendManager;
use App\Service\ECloud\Login\RemoteLoginManager;
use App\Service\ECloud\Message\RemoteReceiveMessageHandle;
use App\Service\WechatBot\Address\RemoteAddressManagerInterface;
use App\Service\WechatBot\Friend\RemoteFriendManagerInterface;
use App\Service\WechatBot\Login\RemoteLoginManagerInterface;
use App\Service\WechatBot\ReceiveMessage\RemoteReceiveMessageHandleInterface;
use App\Service\WechatBot\SendMessage\SendMessageManagerInterface;
use App\Service\WechatBot\ServiceProviderInterface;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ExampleServiceProviderAProvider implements ServiceProviderInterface
{

    protected Config $config;
    protected RemoteLoginManagerInterface $remoteLoginManager;
    protected HttpService $httpService;
    protected RemoteFriendManagerInterface $remoteFriendManager;
    protected RemoteAddressManagerInterface $remoteAddressManager;
    protected RemoteReceiveMessageHandleInterface $remoteReceiveMessageHandle;

    /**
     * @param array $options
     * @throws Exception|GuzzleException
     */
    public function __construct(array $options = [])
    {
        if (empty($options['account'])) {
            throw new \Exception('account is empty');
        }

        if (empty($options['password'])) {
            throw new \Exception('password is empty');
        }

        $this->config                     = new Config($options);
        $this->httpService                = new HttpService(new Client(['base_uri' => $this->config->get('base_uri')]), $this->config);
        $this->remoteLoginManager         = new RemoteLoginManager($this->httpService, $this->config);
        $this->remoteFriendManager        = new RemoteFriendManager($this->httpService);
        $this->remoteAddressManager       = new RemoteAddressManager($this->httpService, $this->config);
        $this->remoteReceiveMessageHandle = new RemoteReceiveMessageHandle();
    }

    public function getRemoteLoginManager(): RemoteLoginManagerInterface
    {
        return $this->remoteLoginManager;
    }

    public function getRemoteFriendManager(): RemoteFriendManagerInterface
    {
        return $this->remoteFriendManager;
    }

    public function getRemoteAddressManager(): RemoteAddressManagerInterface
    {
        return $this->remoteAddressManager;
    }

    public function getRemoteReceiveMessageHandle(): RemoteReceiveMessageHandleInterface
    {
        return $this->remoteReceiveMessageHandle;
    }

    public function getConfig(): Config
    {
        return $this->config;
    }

    public function getSendMessageManager(): SendMessageManagerInterface
    {
        // TODO: Implement getSendMessageManager() method.
    }

}