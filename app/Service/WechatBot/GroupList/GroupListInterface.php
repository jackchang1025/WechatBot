<?php

namespace App\Service\WechatBot\GroupList;

use App\Service\WechatBot\Group\GroupInterface;

interface GroupListInterface
{
    public function getGroupList();
    public function getGroup(string $groupId) : GroupInterface;
}