<?php

namespace App\Service\WechatBot\RepositoryI;

interface UserRepositoryInterface extends RepositoryInterface
{
    //是否登录
    public function isLogin(): bool;

    //是否掉线
    public function isOffline(): bool;

    public function getInstanceId(): ?string;

    public function updateInstanceId(string $instanceId): bool;

    public function updateStatus(string $status): bool;

    public function getUser(string $wechatId);

    public function getFriend(string $wechatId);

    public function getGroup(string $wechatId);

    /**
     * 微信id(唯一值）
     * @return string
     */
    public function getWechatId(): string;

    /**
     * 昵称
     * @return string
     */
    public function getNickName(): string;

    /**
     * 扫码的设备类型
     * @return string
     */
    public function getDeviceType(): string;

    /**
     * 识别码
     * @return int
     */
    public function getUin(): int;

    /**
     * 头像url
     * @return string
     */
    public function getHeadUrl(): string;

    /**
     * 手机上显示的微信号
     * @return string
     */
    public function getWAccount(): string;

    public function getMobilePhone(): string;
    public function getSex(): int;
    public function createFriend(array $data);
    public function updateFriend(array $data);
    public function updateGroup(array $data);
    public function createGroup(array $data);

}