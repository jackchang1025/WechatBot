<?php

namespace App\Service\OneBotWechatBot\Action;

use App\Service\WechatBot\User\UserInterface;

interface ActionInterface
{
    public function execute($interface,...$arguments);
}