<?php

namespace App\Service\WechatBot\User;

use App\Service\WechatBot\Address\AddressListInterface;
use App\Service\WechatBot\Enum\UserStatus;
use App\Service\WechatBot\Friend\FriendInterface;
use App\Service\WechatBot\Group\GroupInterface;
use App\Service\WechatBot\GroupList\GroupListInterface;
use App\Service\WechatBot\SendMessage\MessageFormat\FileInterface;
use App\Service\WechatBot\SendMessage\MessageFormat\ImageInterface;
use App\Service\WechatBot\SendMessage\MessageFormat\TextInterface;
use App\Service\WechatBot\SendMessage\MessageFormat\VideoInterface;
use App\Service\WechatBot\SendMessage\MessageFormat\VoiceInterface;
use App\Service\WechatBot\ServiceProviderInterface;
use App\Service\WechatBot\WechatBotInterface;

class User implements UserInterface
{
    use UserInfo;

    public function __construct(
        protected array $data,
        protected ServiceProviderInterface $serviceProvider,
        protected string $status = UserStatus::NOT_LOGIN->value,
        protected ?GroupListInterface $groupList = null,
        protected ?AddressListInterface $addressList = null
    ) {

    }

    public function setGroupList(GroupListInterface $groupList): void
    {
        $this->groupList = $groupList;
    }

    public function getGroupList(): GroupListInterface
    {
        return $this->groupList;
    }

    public function setAddressList(AddressListInterface $addressList): void
    {
        $this->addressList = $addressList;
    }

    public function getAddressList(): AddressListInterface
    {
        return $this->addressList;
    }

    public function send(FriendInterface|GroupInterface $to, TextInterface $text)
    {
        $this->serviceProvider->getSendMessageManager()->send($this, $to, $text);
    }

    public function sendFile(FriendInterface|GroupInterface $to, FileInterface $file)
    {
        // TODO: Implement sendFile() method.
    }

    public function sendImage(FriendInterface|GroupInterface $to, ImageInterface $image)
    {
        // TODO: Implement sendImage() method.
    }

    public function sendVoice(FriendInterface|GroupInterface $to, VoiceInterface $voice)
    {
        // TODO: Implement sendVoice() method.
    }

    public function sendVideo(FriendInterface|GroupInterface $to, VideoInterface $video)
    {
        // TODO: Implement sendVideo() method.
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->data[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->data[$offset] ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (!isset($this->data[$offset])) {
            $this->data[$offset] = $value;
        }
    }

    public function offsetUnset(mixed $offset): void
    {
        if (isset($this->data[$offset])) {
            unset($this->data[$offset]);;
        }
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function isLogin(): bool
    {
        return $this->status === UserStatus::LOGIN->value;
    }

    public function isOffline(): bool
    {
        return $this->status === UserStatus::OFFLINE->value;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
}