<?php

namespace App\Service\ECloud\MessageFormat;

trait Message
{

    public function __construct(protected array $options)
    {
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