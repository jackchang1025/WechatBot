<?php

namespace App\Service\WechatBot\Middleware;

use App\Service\WechatBot\ReceiveMessage\MessageFormat\MessageInterface;

class Middleware
{

    /**
     * @param mixed $data
     * @param MiddlewareInterface [] $middlewares $middlewares
     */
    public function __construct(protected array $middlewares = [],protected mixed $data = [])
    {
    }

    public function setMiddleware(MiddlewareInterface $middlewares): void
    {
        $this->middlewares[] = $middlewares;
    }

    public function setMiddlewares(array $middlewares): void
    {
        $this->middlewares = array_merge($this->middlewares, $middlewares);
    }

    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

    public function setData(mixed $data): static
    {
        $this->data = $data;
        return $this;
    }

    public function getData(): mixed
    {
        return $this->data;
    }

    public function finalHandler(MessageInterface $request): string
    {
        // 最终处理程序的逻辑
        return "Final response to ";
    }

    public function handle()
    {
        $handler = function($request) {
            return $this->finalHandler($request);
        };

        foreach (array_reverse($this->middlewares) as $middleware) {
            $handler = function($request) use ($middleware, $handler) {
                return $middleware->handle($request, $handler);
            };
        }
        return $handler($this->data);
    }

}