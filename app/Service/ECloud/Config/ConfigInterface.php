<?php

namespace App\Service\ECloud\Config;

interface ConfigInterface
{
    /**
     * @return array<string,mixed>
     */
    public function all(): array;

    public function has(string $key): bool;

    public function set(string $key, mixed $value = null): void;

    /**
     * @param  array<string>|string  $key
     */
    public function get(array|string $key, mixed $default = null): mixed;
}