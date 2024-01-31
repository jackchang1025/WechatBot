<?php

declare(strict_types=1);

namespace App\Model;

use App\Service\WechatBot\Address\AddressListInterface;
use App\Service\WechatBot\Enum\UserStatus;
use App\Service\WechatBot\GroupList\GroupListInterface;
use App\Service\WechatBot\RepositoryI\UserRepositoryInterface;
use Hyperf\Database\Model\Relations\BelongsToMany;
use Hyperf\Database\Model\Relations\HasOne;
use Hyperf\DbConnection\Model\Model;

/**
 * @property string $status 状态
 * @property string $wechat_id 微信id
 * @property string $instance_id 实例id
 * @property string $nick_name 实例id
 * @property string $device_ype 扫码的设备类型
 * @property string $head_url 头像url
 * @property int $sex 性别{1:男,2:女}
 * @property string $phone 手机
 */
class WechatUserModel extends Model implements UserRepositoryInterface
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'wechat_users';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = [
        'status',
        'wechat_id',
        'instance_id',
        'nick_name',
        'device_type',
        'head_url',
        'sex',
        'phone',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['status' => 'string'];

    protected array $attributes = [
        'status' => UserStatus::NOT_LOGIN->value,
    ];

    public function isLogin(): bool
    {
        return $this->status === UserStatus::LOGIN->value;
    }

    public function isOffline(): bool
    {
        return $this->status === UserStatus::OFFLINE->value;
    }

    public function isNotLogin(): bool
    {
        return $this->status === UserStatus::NOT_LOGIN->value;
    }

    public function updateStatus(string $status): bool
    {
        return $this->update(['status' => $status]);
    }

    public function getUser(string $wechatId): \Hyperf\Database\Model\Model|null
    {
        return $this->where('wechat_id', $wechatId)->first();
    }

    public function getFriend(string $wechatId): \Hyperf\Database\Model\Model|null
    {
        return $this->friend()->first();
    }

    public function friend(): HasOne
    {
        return $this->hasOne(Friend::class, 'user_id', 'id');
    }

    public function getInstanceId(): ?string
    {
        return $this->instance_id;
    }

    public function updateInstanceId(string $instanceId): bool
    {
        return $this->update(['instance_id' => $instanceId]);
    }

    public function getWechatId(): string
    {
        return $this->wechat_id;
    }

    public function getNickName(): string
    {
        return $this->nick_name;
    }

    public function getDeviceType(): string
    {
        return $this->device_ype;
    }

    public function getUin(): int
    {
        return $this->uin;
    }

    public function getHeadUrl(): string
    {
        return $this->head_url;
    }

    public function getWAccount(): string
    {
        return $this->account;
    }

    public function getMobilePhone(): string
    {
        return $this->phone;
    }

    public function getSex(): int
    {
        return $this->sex;
    }

    public function getGroup(string $wechatId)
    {
        return $this->groups()->first();
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'group_user', 'user_id', 'group_id');
    }

    public function createFriend(array $data): \Hyperf\Database\Model\Model
    {
        return $this->friend()->create($data);
    }

    public function updateFriend(array $data): int
    {
        return $this->friend()->update($data);
    }

    public function updateGroup(array $data): int
    {
        return $this->groups()->update($data);
    }

    public function createGroup(array $data): \Hyperf\Database\Model\Model
    {
        return $this->groups()->create($data);
    }

    public function updateData(array $data): bool
    {
        // TODO: Implement updateData() method.
    }

    public function getStatus(): string
    {
        // TODO: Implement getStatus() method.
    }

    public function setAddressList(AddressListInterface $addressList)
    {
        // TODO: Implement setAddressList() method.
    }

    public function getAddressList(): AddressListInterface
    {
        // TODO: Implement getAddressList() method.
    }
}
