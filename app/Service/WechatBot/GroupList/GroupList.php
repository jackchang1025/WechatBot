<?php

namespace App\Service\WechatBot\GroupList;

use App\Service\WechatBot\Group\GroupInterface;
use Hyperf\Collection\Collection;

class GroupList implements GroupListInterface
{
    public function __construct(protected array $data,protected ?GroupInterface $group = null)
    {
    }

    public function getGroupList(): array
    {
        return $this->data;
    }

    public function getGroup(string $groupId): GroupInterface
    {
       return Collection::make($this->data)->first(function (GroupInterface $item) use ($groupId) {
           return $item->getGroupId() == $groupId;
       });
    }
}