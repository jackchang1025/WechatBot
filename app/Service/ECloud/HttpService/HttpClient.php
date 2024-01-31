<?php

namespace App\Service\OneBotECloud\HttpService;


use App\Service\ECloud\Config\ConfigInterface;
use App\Service\WechatBot\Exceptions\RetryableException;
use App\Service\WechatBot\Middleware\Pipeline;
use Closure;
use Illuminate\Http\Client\Factory;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Throwable;

/**
// * @method PendingRequest asJson()
// * @method PendingRequest withToken(string $token, $type = 'Bearer')
// * @method PendingRequest withRequestMiddleware(callable $middleware)
// * @method PendingRequest withResponseMiddleware(callable $middleware)
// * @method PendingRequest throwIf($condition)
// * @method PendingRequest retry(int $times, Closure|int $sleepMilliseconds = 0, ?callable $when = null, bool $throw = true)
 */
class HttpClient extends PendingRequest
{
    protected Pipeline $pipeline;

    protected ?Closure $defaultWhenCallback = null;

    public function __construct(protected ConfigInterface $config, Factory $factory = null)
    {
        parent::__construct($factory);
        $this->pipeline = new Pipeline();

        $this->baseUrl($this->config->get('base_uri'));
    }

    public function setDefaultCallback(Closure $defaultWhenCallback): static
    {
        $this->defaultWhenCallback = $defaultWhenCallback;

        return $this;
    }

    public function setResponseMiddleware(mixed $middleware): static
    {
        $this->pipeline->through($middleware);

        return $this;
    }

    public function send(string $method, string $url, array $options = []): Response
    {
        $callback = function () use ($method, $url, $options) {

            $response = parent::send($method, $url, $options);

            return $this->pipeline->send($response)
                ->then($this->getDefaultWhenCallback());
        };

        return retry(
            $this->tries ?? 1,
            $callback,
            $this->retryDelay ?? 100,
            fn($exception) => $exception instanceof RetryableException
        );
    }

    /**
     * @param Response $response
     * @return Response
     * @throws Throwable
     */
    public function retryRequest(Response $response): Response
    {
        return retry($this->tries ?? 1, function () use ($response) {

            return $this->pipeline->send($response)
                ->then($this->getDefaultWhenCallback());

        }, $this->retryDelay ?? 100, fn($exception) => $exception instanceof RetryableException);
    }

    public function getDefaultWhenCallback(): Closure
    {
        return $this->defaultWhenCallback ??= fn(Response $response) => $response;
    }
}

