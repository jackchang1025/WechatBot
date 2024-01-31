<?php

namespace App\Service\WechatBot\RepositoryI;

use App\Model\WechatUserModel;
use App\Service\WechatBot\Enum\UserStatus;
use Hyperf\Database\Model\Collection;

class UserRepository
{

    public function __construct(public WechatUserModel $model)
    {
    }

    public function isLogin(): bool
    {
        return $this->model->status === UserStatus::LOGIN->value;
    }

    public function isOffline(): bool
    {
        return $this->model->status === UserStatus::OFFLINE->value;
    }

    public function isNotLogin(): bool
    {
        return $this->model->status === UserStatus::NOT_LOGIN->value;
    }

    public function getAddressList(): array|Collection
    {
        return $this->model->with('addressList')->all();
    }

    public function getInstanceId(): ?string{
        return $this->model->instance_id;
    }

    public function update(){}
    public function find(){}
    public function all(){}

    public function updateInstanceId(string $instanceId): bool
    {
        return $this->model->update(['instance_id'=>$instanceId]);
    }

    public function updateStatus(string $status): bool
    {
        return $this->model->update(['status'=>$status]);
    }

    public function findUser(string $wechatId)
    {
        // TODO: Implement findUser() method.
    }

    public function findFriend(string $wechatId)
    {
        // TODO: Implement findFriend() method.
    }
}