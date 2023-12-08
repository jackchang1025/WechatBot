<?php

namespace App\Service\WechatBot\Group;

class Group implements GroupInterface
{
    public function __construct(protected array $data = [])
    {
    }

    public function getGroupId(): string
    {
        return $this->data['group_id'] ?? '';
    }
}