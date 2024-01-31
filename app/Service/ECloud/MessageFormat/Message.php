<?php

namespace App\Service\ECloud\MessageFormat;

use App\Service\WechatBot\Friend\FriendInterface;
use App\Service\WechatBot\Group\GroupInterface;
use App\Service\WechatBot\User\UserInterface;
use App\Service\WechatBot\WechatBotInterface;

trait Message
{

    public function __construct(protected array $options,protected ?UserInterface $user = null)
    {
    }

    public function setUser(UserInterface $user): void
    {
        $this->user = $user;
    }


    public function toUser(): ?UserInterface
    {
        return $this->user;
    }

    public function toFromGroup(): GroupInterface
    {
        //透过 toUser 找到用户 getGroupList 找到群列表 getGroup 找到群信息
        return $this->toUser()?->findGroup($this->getFromGroup());
    }

    /**
     *
     * @return FriendInterface
     */

    public function toFromUser(): FriendInterface
    {
        //透过 toUser 找到用户 getAddressList 找到用户通讯录 getAddress 找到好友
        return $this->toUser()?->findFriend($this->getFromUser());
    }


    /**
     * 获取消息内容
     * @return string
     */
    public function getContent(): string
    {
        return $this->options['data']['content'] ?? '';
    }

    /**
     * 获取消息发送者
     * @return string
     */
    public function getFromUser(): string
    {
        return $this->options['data']['fromUser'] ?? '';
    }

    /**
     * 获取消息接收者
     * @return string
     */
    public function getToUser(): string
    {
        return $this->options['data']['toUser'] ?? '';
    }

    public function getFromGroup():string
    {
        return $this->options['data']['fromUser'] ?? '';
    }

    /**
     * 获取消息ID
     * @return int
     */
    public function getMsgId(): int
    {
        return $this->options['data']['msgId'] ?? 0;
    }

    /**
     * 获取新消息ID
     * @return int
     */
    public function getNewMsgId(): int
    {
        return $this->options['data']['newMsgId'] ?? 0;
    }

    public function getTimestamp(): int
    {
        return $this->options['data']['timestamp'] ?? 0;
    }

    public function getWId(): string
    {
        return $this->options['data']['wId'] ?? '';
    }

    public function getSelf(): bool
    {
        return $this->options['data']['self'] ?? false;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function getData(): array
    {
        return $this->options['data'];
    }

    public function getAccount(): string
    {
        return $this->options['account'];
    }

    public function getWcId(): string
    {
        return $this->options['wcId'];
    }
}