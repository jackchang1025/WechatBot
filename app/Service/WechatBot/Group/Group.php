<?php

namespace App\Service\WechatBot\Group;

class Group implements GroupInterface
{
    public function __construct(protected array $data = [])
    {
    }

}