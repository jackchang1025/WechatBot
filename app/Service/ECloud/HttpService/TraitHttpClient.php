<?php

namespace App\Service\OneBotECloud\HttpService;

use App\Service\ECloud\ApiResponseHandler;
use App\Service\ECloud\Config\ConfigInterface;
use App\Service\WechatBot\Exceptions\ApiResponseException;
use App\Service\WechatBot\Exceptions\ConfirmLoginException;
use App\Service\WechatBot\Response;
use App\Service\WechatBot\ResponseInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Middleware;
use Illuminate\Http\Client\Factory;
use Illuminate\Http\Client\PendingRequest;
use Psr\Http\Message\RequestInterface;

Trait TraitHttpClient
{
    /**
     * @var HttpClient|null
     */
    protected ?HttpClient $httpClient = null;

    abstract function getConfig(): ConfigInterface;

    public function setHttpClient(HttpClient $httpClient): void
    {
        $this->httpClient = $httpClient;
    }

    public function getHttpClient(): HttpClient
    {
        return $this->httpClient ??= new HttpClient($this->getConfig());
    }

}