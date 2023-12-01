<?php

namespace App\Service\ECloud;

use Swoole\Coroutine\Http\Server;

readonly class EYunService
{
    protected readonly Server $server;

    public function __construct(protected string $host = '0.0.0.0',protected int $port = 9503,protected readonly bool $ssl = false)
    {
        $this->server = new Server($this->host, $this->port, $this->ssl);
    }

    public function addRoute($route, $callback): static
    {
        $this->server->handle($route, $callback);
        return $this;
    }

    public function start(): void
    {
        try {
            echo "准备启动 Swoole HTTP 服务 {$this->host}:{$this->port} \n";

            $this->server->start();

        } catch (\Exception $e) {

            echo "Swoole HTTP 服务器启动失败: ". $e->getMessage(). "\n";
        }
    }
}