<?php

namespace App\Service\Adapter;

use App\Service\Adapter\AdapterInterface;
use App\Service\OneBot\Event\Message\MessageFormat;
use App\Service\OneBot\Event\Message\PrivateMessageEvent;
use App\Service\OneBot\Event\OneBotEvent;
use App\Service\OneBot\Event\SelfInfo;
use App\Service\OneBot\Message\Message;
use App\Service\OneBot\Message\MessageSegment;
use FastRoute\Dispatcher;
use Hyperf\Context\Context;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Coordinator\Constants;
use Hyperf\Coordinator\CoordinatorManager;
use Hyperf\Dispatcher\HttpDispatcher;
use Hyperf\ExceptionHandler\ExceptionHandlerDispatcher;
use Hyperf\HttpMessage\Server\Connection\SwooleConnection;
use Hyperf\HttpMessage\Server\Request as Psr7Request;
use Hyperf\HttpMessage\Server\Response as Psr7Response;
use Hyperf\HttpServer\Contract\CoreMiddlewareInterface;
use Hyperf\HttpServer\CoreMiddleware;
use Hyperf\HttpServer\Event\RequestHandled;
use Hyperf\HttpServer\Event\RequestReceived;
use Hyperf\HttpServer\Event\RequestTerminated;
use Hyperf\HttpServer\Exception\Handler\HttpExceptionHandler;
use Hyperf\HttpServer\MiddlewareManager;
use Hyperf\HttpServer\ResponseEmitter;
use Hyperf\HttpServer\Router\Dispatched;
use Hyperf\HttpServer\Router\DispatcherFactory;
use Hyperf\Server\Option;
use Hyperf\Server\ServerFactory;
use Hyperf\Support\SafeCaller;
use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;
use function Hyperf\Coroutine\defer;
use function Hyperf\Support\make;

class ECloud implements AdapterInterface
{
    protected ?EventDispatcherInterface $event = null;

    protected ?Option $option = null;

    protected array $middlewares = [];

    protected ?CoreMiddlewareInterface $coreMiddleware = null;

    protected array $exceptionHandlers = [];

    protected ?string $serverName = 'ecloud';

    public function __construct(
        protected ContainerInterface $container,
        protected HttpDispatcher $dispatcher,
        protected ExceptionHandlerDispatcher $exceptionHandlerDispatcher,
        protected ResponseEmitter $responseEmitter
    ) {
        if ($this->container->has(EventDispatcherInterface::class)) {
            $this->event = $this->container->get(EventDispatcherInterface::class);
        }

        $this->coreMiddleware = make(CoreMiddleware::class, [$this->container, $this->serverName]);
    }

    public function initCoreMiddleware(string $serverName): void
    {
        $this->serverName = $serverName;
        $this->coreMiddleware = $this->createCoreMiddleware();

        $config = $this->container->get(ConfigInterface::class);
        $this->middlewares = $config->get('middlewares.' . $serverName, []);
        $this->exceptionHandlers = $config->get('exceptions.handler.' . $serverName, $this->getDefaultExceptionHandler());

        $this->initOption();
    }

    public function getServerName(): string
    {
        return $this->serverName;
    }

    /**
     * @return $this
     */
    public function setServerName(string $serverName)
    {
        $this->serverName = $serverName;
        return $this;
    }

    protected function initOption(): void
    {
        $ports = $this->container->get(ServerFactory::class)->getConfig()?->getServers();
        if (! $ports) {
            return;
        }

        foreach ($ports as $port) {
            if ($port->getName() === $this->serverName) {
                $this->option = $port->getOptions();
            }
        }

        $this->option ??= Option::make([]);
        $this->option->setMustSortMiddlewaresByMiddlewares($this->middlewares);
    }

    protected function createDispatcher(string $serverName): Dispatcher
    {
        $factory = $this->container->get(DispatcherFactory::class);
        return $factory->getDispatcher($serverName);
    }

    protected function getDefaultExceptionHandler(): array
    {
        return [
            HttpExceptionHandler::class,
        ];
    }

    protected function createCoreMiddleware(): CoreMiddlewareInterface
    {
        return make(CoreMiddleware::class, [$this->container, $this->serverName]);
    }

    public function formatRemoteServiceOneBot(array $data): OneBotEvent
    {
        return MessageFormat::formatRemoteServiceOneBot($data);
    }

    public function onRequest($request, $response): void
    {
        try {

            // 等待 Worker 进程启动
            CoordinatorManager::until(Constants::WORKER_START)->yield();


            // 初始化 PSR-7 请求和响应对象
            [$psr7Request, $psr7Response] = $this->initRequestAndResponse($request, $response);

            // 如果启用了请求生命周期事件，触发请求接收事件
            $this->option?->isEnableRequestLifecycle() && $this->event?->dispatch(new RequestReceived(
                request: $psr7Request,
                response: $psr7Response,
                server: $this->serverName
            ));

            // 使用核心中间件处理请求
            $psr7Request = $this->coreMiddleware->dispatch($psr7Request);

            // 获取分发信息
            $dispatched = $psr7Request->getAttribute(Dispatched::class);
            $middlewares = $this->middlewares;


            // 如果找到了路由处理程序，获取注册的中间件
            $registeredMiddlewares = [];
            if ($dispatched->isFound()) {
                $registeredMiddlewares = MiddlewareManager::get($this->serverName, $dispatched->handler->route, $psr7Request->getMethod());
                $middlewares = array_merge($middlewares, $registeredMiddlewares);
            }

            // 如果需要排序中间件或存在注册的中间件，则对中间件进行排序
            if ($this->option?->isMustSortMiddlewares() || $registeredMiddlewares) {
                $middlewares = MiddlewareManager::sortMiddlewares($middlewares);
            }

            // 分发请求到中间件栈并处理
            $psr7Response = $this->dispatcher->dispatch($psr7Request, $middlewares, $this->coreMiddleware);
        } catch (Throwable $throwable) {
            // 处理异常，委托给异常处理器
            var_dump($throwable);
            $psr7Response = $this->container->get(SafeCaller::class)->call(function () use ($throwable) {
                return $this->exceptionHandlerDispatcher->dispatch($throwable, $this->exceptionHandlers);
            }, static function () {
                return (new Psr7Response())->withStatus(400);
            });
        } finally {
            // 如果启用了请求生命周期事件，在请求结束时触发相应事件
            if (isset($psr7Request) && $this->option?->isEnableRequestLifecycle()) {
                defer(fn () => $this->event?->dispatch(new RequestTerminated(
                    request: $psr7Request,
                    response: $psr7Response ?? null,
                    exception: $throwable ?? null,
                    server: $this->serverName
                )));

                $this->event?->dispatch(new RequestHandled(
                    request: $psr7Request,
                    response: $psr7Response ?? null,
                    exception: $throwable ?? null,
                    server: $this->serverName
                ));
            }

            // 向客户端发送响应
            if (isset($psr7Response) && $psr7Response instanceof ResponseInterface) {
                if (isset($psr7Request) && $psr7Request->getMethod() === 'HEAD') {
                    $this->responseEmitter->emit($psr7Response, $response, false);
                } else {
                    $this->responseEmitter->emit($psr7Response, $response);
                }
            }
        }
    }

    protected function initRequestAndResponse($request, $response): array
    {
        Context::set(ResponseInterface::class, $psr7Response = new Psr7Response());

        $psr7Response->setConnection(new SwooleConnection($response));

        if ($request instanceof ServerRequestInterface) {
            $psr7Request = $request;
        } else {
            $psr7Request = Psr7Request::loadFromSwooleRequest($request);
        }

        Context::set(ServerRequestInterface::class, $psr7Request);

        return [$psr7Request, $psr7Response];
    }

    public function onMessage()
    {
        // TODO: Implement onMessage() method.
    }

    public function onClose()
    {
        // TODO: Implement onClose() method.
    }
}