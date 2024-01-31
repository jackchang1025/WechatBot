<?php

declare(strict_types=1);

namespace App\Listener;

use App\Service\OneBot\Event\Message\PrivateMessageEvent;
use App\Service\OneBot\Message\Message;
use App\Service\WechatBot\BotManager;
use Hyperf\Event\Annotation\Listener;
use Psr\Container\ContainerInterface;
use Hyperf\Event\Contract\ListenerInterface;

#[Listener]
class PrivateMessageEventListener implements ListenerInterface
{
    public function __construct(protected ContainerInterface $container)
    {
    }

    public function listen(): array
    {
        return [
            PrivateMessageEvent::class, // 监听私信事件
        ];
    }

    public function process(object $event): void
    {
        /**
         * @var PrivateMessageEvent $event
         */

        $bot = $event->userId;

        //获取机器人
        $botManager = $this->container->get(BotManager::class);

        $bot = $botManager->findBotByWcId($bot);

//        $bot->receiveMessageHandle(Message::create($event->message));
    }
}
