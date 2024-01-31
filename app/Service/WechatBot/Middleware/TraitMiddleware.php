<?php

namespace App\Service\WechatBot\Middleware;


use App\Service\WechatBot\Login\QRCodeResponseInterface;
use App\Service\WechatBot\ReceiveMessage\MessageFormat\MessageInterface;

trait TraitMiddleware
{
    // 中间件回调数组
    private array $middlewares = [
        'getQRCode' => [],
    ];

    protected Pipeline $pipeline;

    public function setPipeline(Pipeline $pipeline): static
    {
        $this->pipeline = $pipeline;

        return $this;
    }

    public function getPipeline(): Pipeline
    {
        return $this->pipeline ??= new Pipeline();
    }

    // 中间件处理方法
    public function getQRCode($callback) {
        // 注册登录前的回调
    }

    public function withGetQRCode(mixed $handler): static
    {
        $this->getPipeline()->whenHandle(fn ($passable) => $passable instanceof QRCodeResponseInterface , $handler);

        return $this;
    }

    public function withThenReceiveMessage(mixed $handler): static
    {
        $this->getPipeline()->whenHandle(fn ($passable) => $passable instanceof MessageInterface, $handler);

        return $this;
    }

    public function with(mixed $middleware): static
    {
        $this->getPipeline()->through($middleware);

        return $this;
    }

    public function then(mixed $condition, mixed $pipe): static
    {
        $this->getPipeline()->when($condition, $pipe);

        return $this;
    }

    public function thenHandle(mixed $message,callable|null $callback = null):mixed
    {
        return $this->getPipeline()
            ->send($message)
            ->then($callback ?? fn($message) => $message);
    }
}