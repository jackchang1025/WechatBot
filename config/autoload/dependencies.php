<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

use App\Service\GeneratorFactory;
use App\Service\ServiceProviderInterfaceFactory;
use App\Service\WechatBot\ServiceProviderInterface;
use App\Service\WechatBot\WechatBotInterface;
use App\Service\WechatBotFactory;
use Faker\Generator;

return [
    WechatBotInterface::class => WechatBotFactory::class,
    Generator::class => GeneratorFactory::class,
    ServiceProviderInterface::class => ServiceProviderInterfaceFactory::class,
];
