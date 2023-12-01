<?php

namespace App\Service\ECloud;

use App\Service\ECloud\Login\LoginManager;
use App\Service\ECloud\Message\ReceiveMessage;
use App\Service\ECloud\Message\ReceiveMessageHandle;
use App\Service\WechatBot\Address\AddressInterface;
use App\Service\WechatBot\Address\AddressManager;
use App\Service\WechatBot\Friend\FriendInterface;
use App\Service\WechatBot\Friend\Friends;
use App\Service\WechatBot\Login\LoginManagerInterface;
use App\Service\WechatBot\ReceiveMessage\ReceiveMessageHandleInterface;
use App\Service\WechatBot\ReceiveMessage\ReceiveMessageInterface;
use App\Service\WechatBot\SendMessage\SendMessageManagerInterface;
use App\Service\WechatBot\ServiceProviderInterface;
use App\Service\WechatBot\User\User;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ExampleServiceProviderAProvider implements ServiceProviderInterface
{

    const URL = 'https://api.weixin.qq.com/';

    protected Client $httpClient;

    protected Config $config;
    protected LoginManagerInterface $loginManager;
    protected HttpService $httpService;
    protected FriendInterface $friend;
    protected AddressInterface $address;
    protected ReceiveMessageInterface $receiveMessage;
    protected ReceiveMessageHandleInterface $messageHandle;

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

        $this->config         = new Config($options);
        $this->httpClient     = new Client(['base_uri' => $this->config->get('base_uri')]);
        $this->httpService    = new HttpService($this->httpClient, $this->config);
        $this->loginManager   = new LoginManager($this->httpService, $this->config);
        $this->friend         = new Friends($this->httpService);
        $this->address        = new AddressManager($this->httpService, $this->config);
        $this->receiveMessage = new ReceiveMessage($this->httpService, $this->config);
        $this->messageHandle  = new ReceiveMessageHandle();
    }

    public function getLoginManager(): LoginManagerInterface
    {
        return $this->loginManager;
    }

    public function getFriendsManager(): FriendInterface
    {
        return $this->friend;
    }

    public function getAddressManager(): AddressInterface
    {
        return $this->address;
    }

    public function getReceiveMessageHandle(): ReceiveMessageHandleInterface
    {
        return $this->messageHandle;
    }

    public function getMomentsManager()
    {
        // TODO: Implement getMomentsManager() method.
    }

    public function receiveMessage(): ReceiveMessageInterface
    {
        return $this->receiveMessage;
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