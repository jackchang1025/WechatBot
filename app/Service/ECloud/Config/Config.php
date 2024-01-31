<?php

namespace App\Service\ECloud\Config;

use App\Service\WechatBot\Exceptions\ConfigException;
use Illuminate\Support\Collection;

class Config implements ConfigInterface
{
    protected Collection $config;

    /**
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->config = new Collection($options);
    }

    // 使用 'get' 方法获取配置项
    public function get(string|array $key, $default = null): mixed
    {
        return $this->config->get($key) ?? $default;
    }

    // 使用 'set' 方法设置配置项
    public function set(string $key, mixed $value = null): void
    {
        $this->config->set($key, $value);
    }

    public function all(): array
    {
        return $this->config->all();
    }

    public function has(string $key): bool
    {
        return $this->config->has($key);
    }
}