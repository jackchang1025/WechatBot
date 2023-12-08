<?php

namespace App\Event;


use App\Service\WechatBot\User\UserInterface;

class UserInitEvent
{

    public function __construct(public UserInterface $user)
    {
    }
}