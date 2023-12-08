<?php

namespace App\Listener;

use App\Event\UserInitEvent;
use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Event\Annotation\Listener;

#[Listener]
class UserInitListener implements ListenerInterface
{

    public function listen(): array
    {
        return [
            UserInitEvent::class,
        ];
    }

    public function process(object $event): void
    {
        var_dump($event->user->getData());
    }
}