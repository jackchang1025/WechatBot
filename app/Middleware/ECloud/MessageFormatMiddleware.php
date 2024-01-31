<?php

declare(strict_types=1);

namespace App\Middleware\ECloud;


use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class MessageFormatMiddleware implements MiddlewareInterface
{
    public function __construct(protected ContainerInterface $container)
    {

    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $event = MessageFormat::formatRemoteServiceOneBot($request->getParsedBody());

        var_dump($event);

        if ($this->container->has(EventDispatcherInterface::class)) {
            $EventDispatcherInterface = $this->container->get(EventDispatcherInterface::class);
            $EventDispatcherInterface->dispatch($event);
        }
        return $handler->handle($request);
    }
}
