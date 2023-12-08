<?php

namespace App\Service\WechatBot\ReceiveMessage\MessageFormat;

use App\Service\WechatBot\User\UserInterface;

interface MessageInterface
{
    public function getContent(): string;

    public function getFromUser(): string;

    public function getMsgId(): int;

    public function getNewMsgId(): int;

    public function getSelf(): bool;

    public function getTimestamp(): int;

    public function getToUser(): string;
    public function getFromGroup(): string;

    public function getWId(): string;

    public function getOptions(): array;

    public function getData(): array;

    public function getWcId(): string;

    public function getAccount(): string;

    public function toUser(): UserInterface;

}