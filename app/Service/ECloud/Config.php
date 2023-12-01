<?php

namespace App\Service\ECloud;

class Config
{
    private array $config;

    public function __construct(array $initialConfig = []) {
        $this->config = $initialConfig;
    }

    // 使用 'get' 方法获取配置项
    public function get($key, $default = null) {
        return $this->config[$key] ?? $default;
    }

    // 使用 'set' 方法设置配置项
    public function set($key, $value): void
    {
        $this->config[$key] = $value;
    }
}