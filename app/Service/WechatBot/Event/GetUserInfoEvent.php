<?php

namespace App\Service\WechatBot\Event;

use App\Service\WechatBot\RepositoryI\UserRepositoryInterface;

class GetUserInfoEvent
{

    public function __construct(public UserRepositoryInterface $repository)
    {
    }
}