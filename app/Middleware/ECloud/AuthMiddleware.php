<?php

declare(strict_types=1);

namespace App\Middleware\ECloud;

use App\Service\WechatBot\Exceptions\AuthorizationException;
use Hyperf\Contract\ConfigInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

readonly class AuthMiddleware implements MiddlewareInterface
{
    public function __construct(protected ContainerInterface $container,protected ConfigInterface $config)
    {

    }

    /**
     * @throws AuthorizationException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // 从请求中获取 Authorization 字段
        $authorization = $request->getHeaderLine('Authorization');

        // 实现你的验证逻辑
        if (!$this->isValid($authorization)) {
            throw new AuthorizationException();
        }

        return $handler->handle($request);
    }

    private function isValid($authorization): bool
    {
        return $authorization === $this->config->get('wechat.Authorization');
    }
}
