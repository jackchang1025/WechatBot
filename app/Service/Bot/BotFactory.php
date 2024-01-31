<?php

namespace App\Service\Bot;

use Hyperf\Context\ApplicationContext;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Contract\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Weijiajia\Bot\Bot;

class BotFactory
{
    public static function create(
        ?string $userId = null,
        ?string $device = null,
        ?EventDispatcherInterface $eventDispatcher = null
    ): Bot {
        $eventDispatcher ??= ApplicationContext::getContainer()->get('EventDispatcherInterface');

        $config = ApplicationContext::getContainer()->get(ConfigInterface::class);
        $device          ??= $config->get('bot.device.default');

        if ($userId) {
            return new Bot(User::find($userId), $device, $eventDispatcher);
        }

        return new Bot(User::create(), $device, $eventDispatcher);
    }
}