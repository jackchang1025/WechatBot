<?php

namespace App\Service\WechatBot\User;

use App\Service\WechatBot\Address\AddressListInterface;
use App\Service\WechatBot\Friend\FriendInterface;
use App\Service\WechatBot\Group\GroupInterface;
use App\Service\WechatBot\GroupList\GroupListInterface;
use App\Service\WechatBot\RepositoryI\RepositoryInterface;
use App\Service\WechatBot\SendMessage\MessageFormat\FileInterface;
use App\Service\WechatBot\SendMessage\MessageFormat\ImageInterface;
use App\Service\WechatBot\SendMessage\MessageFormat\TextInterface;
use App\Service\WechatBot\SendMessage\MessageFormat\VideoInterface;
use App\Service\WechatBot\SendMessage\MessageFormat\VoiceInterface;
use App\Service\WechatBot\User\Login\LoginManagerInterface;

interface UserInterface
{

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

    public function getInstanceId(): ?string;

    /**
     * 手机上显示的微信号
     * @return string
     */
    public function getWAccount(): string;

    public function getRepository(): RepositoryInterface;

    /**
     * 性别
     * @return int
     */
    public function getSex(): int;

    /**
     * @return string
     */
    public function getMobilePhone(): string;

    //是否登录
    public function isLogin(): bool;

    //是否掉线
    public function isOffline(): bool;

    public function isNotLogin(): bool;

    public function updateData(array $data):bool;

    public function getStatus(): string;

    public function updateStatus(string $status): bool;


    public function setAddressList(AddressListInterface $addressList);

    public function getAddressList(): AddressListInterface;

    public function send(FriendInterface|GroupInterface $to, TextInterface $text);

    public function sendFile(FriendInterface|GroupInterface $to, FileInterface $file);

    public function sendImage(FriendInterface|GroupInterface $to, ImageInterface $image);

    public function sendVoice(FriendInterface|GroupInterface $to, VoiceInterface $voice);

    public function sendVideo(FriendInterface|GroupInterface $to, VideoInterface $video);

    public function getQRCode();

    public function getFriend(string $wechatId):FriendInterface;
    public function getGroup(string $wechatId):GroupInterface;
}