<?php

declare(strict_types=1);

namespace App\Service\WechatBot\Middleware;

use App\Service\WechatBot\Login\QRCodeResponseInterface;
use Closure;
use InvalidArgumentException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * 这个 Pipeline 类可以用于将数据通过一系列处理器（pipes）进行处理，
 * 每个处理器可以对数据进行处理并传递给下一个处理器。
 * 处理器可以是闭包、对象或者类名字符串。
 * 如果是字符串，则会从传入的容器中解析出相应的对象
 */
class Pipeline
{

    // 需要传递通过管道的数据
    protected mixed $passable;

    // 管道数组，用于存放一系列处理器
    protected array $pipes = [];

    // 默认调用的方法名
    protected string $method = 'handle';

    /**
     * @param ContainerInterface|null $container 容器实例，用于解析管道中的处理器
     */
    public function __construct(protected ?ContainerInterface $container = null)
    {
    }

    // 设置需要通过管道传递的数据
    public function send(mixed $passable): self
    {
        $this->passable = $passable;

        return $this;
    }

    // 设置管道中的处理器，可以是一个数组或者多个参数
    public function through(mixed $pipes): self
    {
        if (is_array($pipes)) {
            $this->pipes = array_merge($this->pipes, $pipes);
        } else {
            $this->pipes[] = $pipes;
        }

        return $this;
    }

    /**
     * 根据条件添加处理器到管道。
     *
     * @param bool|Closure $condition 判断是否添加处理器的条件
     * @param mixed $pipe 待添加的处理器
     * @return self
     */
    public function when(mixed $condition, mixed $pipe): self
    {
        if ($this->evaluateCondition($condition)){
            $this->through($pipe);
        }
        return $this;
    }

    public function whenHandle(mixed $condition, mixed $pipe): self
    {
        $this->through(function ($passable, Closure $next) use ($condition,$pipe): mixed {

            return $this->evaluateCondition($condition) ? $pipe($passable, $next) : $next($passable);
        });
        return $this;
    }

    protected function evaluateCondition(mixed $condition): bool
    {
        try {
            if ($condition instanceof Closure) {
                return (bool) $condition($this->passable);
            }

            return (bool) $condition;
        } catch (Throwable $e) {
            // Handle or log the exception if needed
            return false;
        }
    }

    // 设置在管道处理器上调用的方法名
    public function via(string $method): self
    {
        $this->method = $method;

        return $this;
    }

    // 定义管道的终点并开始处理流程
    public function then(Closure $destination): mixed
    {
        $pipeline = array_reduce(array_reverse($this->pipes), $this->carry(), $this->prepareDestination($destination));

        return $pipeline($this->passable);
    }

    // 准备管道的终点闭包
    protected function prepareDestination(Closure $destination): Closure
    {
        return static function ($passable) use ($destination) {
            return $destination($passable);
        };
    }

    // 创建一个用于连接管道各个部分的闭包
    protected function carry(): Closure
    {
        return function ($stack, $pipe) {
            return function ($passable) use ($stack, $pipe) {
                // 如果管道是可调用的，则直接调用
                if (is_callable($pipe)) {
                    return $pipe($passable, $stack);
                }

                // 处理字符串形式的管道，解析类名和参数
                if (!is_object($pipe)) {
                    [$name, $parameters] = $this->parsePipeString($pipe);

                    $pipe = $this->container ? $this->container->get($name) : $this->makeClosure($name);
                    $parameters = array_merge([$passable, $stack], $parameters);
                } else {
                    $parameters = [$passable, $stack];
                }

                // 调用管道上的处理方法
                $carry = method_exists($pipe, $this->method) ? $pipe->{$this->method}(...$parameters) : $pipe(...$parameters);

                return $this->handleCarry($carry);
            };
        };
    }

    protected function makeClosure(callable|string $handler): callable
    {
        if (is_callable($handler)) {
            return $handler;
        }

        if (class_exists($handler) && method_exists($handler, $this->method)) {
            return fn(): mixed => (new $handler())(...func_get_args());
        }

        throw new InvalidArgumentException(sprintf('Invalid handler: %s.', $handler));
    }

    // 解析字符串形式的管道，分离类名和参数
    protected function parsePipeString(string $pipe): array
    {
        [$name, $parameters] = array_pad(explode(':', $pipe, 2), 2, []);

        if (is_string($parameters)) {
            $parameters = explode(',', $parameters);
        }

        return [$name, $parameters];
    }

    // 处理管道的返回值
    protected function handleCarry(mixed $carry): mixed
    {
        return $carry;
    }
}

