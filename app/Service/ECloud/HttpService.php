<?php

namespace App\Service\ECloud;

use GuzzleHttp\Client;
use GuzzleHttp\Middleware;
use Psr\Http\Message\RequestInterface;

class HttpService
{
    private Client $httpClient;

    public function __construct(Client $httpClient, Config $config)
    {
        $this->httpClient = $httpClient;
        $this->configureHttpClient($config);
    }

    private function configureHttpClient(Config $config): void
    {
        // 配置传入的 HTTP 客户端
        $this->httpClient->getConfig('handler')->push(
            Middleware::mapRequest(function (RequestInterface $request) use ($config) {

                // 获取完整的 URI
                $fullUri = (string)$request->getUri();

                var_dump($fullUri);

                if (!str_contains($request->getUri(), '/member/login')) {
                    $authToken = $config->get('Authorization');
                    if ($authToken) {
                        $request = $request->withHeader('Authorization', $authToken);
                    }
                }

                return $request;
            })
        );

        $this->httpClient->getConfig('handler')->push(
            Middleware::mapRequest(function (RequestInterface $request) use ($config) {

                return $request->withHeader('Content-Type', 'application/json');
            })
        );
    }

    /**
     * @param string $url
     * @param array $data
     * @return array
     * @throws \App\Service\WechatBot\Exceptions\ApiResponseException
     * @throws \App\Service\WechatBot\Exceptions\ConfirmLoginException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function post(string $url, array $data = []): array
    {
        // 使用配置好的 $httpClient 发送请求
        $response = $this->httpClient->post($url, ['json' => $data]);

        // 使用 ApiResponseHandler 处理响应
        return ApiResponseHandler::handleResponse($response);
    }
}

