<?php

namespace App\Service\WechatBot;

use App\Service\WechatBot\User\UserInterface;
use App\Service\WechatBot\User\UserManagerInterface;

interface WechatBotInterface
{
    public function start();

    public function getUserManager():UserInterface;

}