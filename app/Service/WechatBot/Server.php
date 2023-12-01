<?php

namespace App\Service\WechatBot;

use Swoole\Coroutine\Http\Server as HttpServer;
use Swoole\Http\Request;
use Swoole\Http\Response;


class Server
{
    protected HttpServer $server;

    /**
     * Server constructor.
     */
    public function __construct(protected readonly WechatBot $wechatBot,protected string $host = '0.0.0.0',protected int $port = 9502)
    {
        $this->server = new HttpServer($this->host, $this->port, false);

        $this->inintialize();
    }

    protected function inintialize()
    {
        $this->setCallbackUrl();
    }

    public function setCallbackUrl(): void
    {
        $config = $this->wechatBot->getServiceProvider()->getConfig();

        $this->addRoute($config->get('http_callback_url'),function (Request $request, Response $response){

//            var_dump($request->post);
            return $this->wechatBot->receiveMessageHandle($request->post);
        });
    }

    public function addRoute($route, $callback): static
    {
        $this->server->handle($route, $callback);
        return $this;
    }

    public function start(): void
    {

        try {

            $this->wechatBot->start();

            echo "准备启动 Swoole HTTP 服务 {$this->host}:{$this->port} \n";

            $this->server->start();

        } catch (\Exception $e) {

            echo "Swoole HTTP 服务器启动失败: " . $e->getMessage() . "\n";
        }
    }
}