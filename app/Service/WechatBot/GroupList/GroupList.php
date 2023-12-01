<?php

namespace App\Service\WechatBot\GroupList;

use App\Service\WechatBot\Group\GroupInterface;

class GroupList implements GroupListInterface
{
    public function __construct(protected array $data,protected ?GroupInterface $group = null)
    {
    }
}