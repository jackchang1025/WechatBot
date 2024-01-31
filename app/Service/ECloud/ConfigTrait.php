<?php

namespace App\Service\ECloud;

use App\Service\ECloud\Config\Config;
use App\Service\ECloud\Config\ConfigInterface;

trait ConfigTrait
{
   protected ConfigInterface $config;

    /**
     * @param array|ConfigInterface $config
     * @return void
     * @throws \App\Service\WechatBot\Exceptions\ConfigException
     */
    public function initConfig(array|ConfigInterface $config): void
    {
        $this->config = is_array($config) ? new Config($config) : $config;
    }

    public function getConfig(): ConfigInterface
    {
        return $this->config;
    }

    public function setConfig(ConfigInterface $config): static
    {
        $this->config = $config;

        return $this;
    }
}