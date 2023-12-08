<?php

namespace App\Service;

use Faker\Factory;
use Faker\Generator;
use Hyperf\Contract\ContainerInterface;

class GeneratorFactory
{
    public function __invoke(ContainerInterface $container, array $parameters = []): Generator
    {
        return Factory::create('zh_CN');
    }
}