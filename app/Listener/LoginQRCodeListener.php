<?php

namespace App\Listener;

use App\Event\LoginQRCodeEvent;
use App\Service\ECloud\Login\LoginHandle;
use App\Service\WechatBot\Login\LoginHandleInterface;
use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Event\Annotation\Listener;

#[Listener]
class LoginQRCodeListener implements ListenerInterface
{
    protected LoginHandleInterface $loginHandle;

    public function __construct()
    {
        $this->loginHandle = make(LoginHandle::class);
    }

    public function listen(): array
    {
        return [
            LoginQRCodeEvent::class,
        ];
    }

    public function process(object $event): void
    {
        echo $this->loginHandle->qRCodeUrlHandle($event->response);
    }
}