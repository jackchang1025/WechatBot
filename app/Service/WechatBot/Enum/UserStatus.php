<?php

namespace App\Service\WechatBot\Enum;

enum UserStatus:string
{
    //未登录
    case NOT_LOGIN = 'NOT_LOGIN';

    //已登录
    case LOGIN = 'LOGIN';

    //已掉线
    case OFFLINE = 'OFFLINE';
}