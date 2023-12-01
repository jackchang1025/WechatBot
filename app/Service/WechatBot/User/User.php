<?php

namespace App\Service\WechatBot\User;

use App\Service\WechatBot\Address\AddressListInterface;
use App\Service\WechatBot\Friend\FriendInterface;
use App\Service\WechatBot\Group\GroupInterface;
use App\Service\WechatBot\GroupList\GroupListInterface;
use App\Service\WechatBot\SendMessage\MessageFormat\FileInterface;
use App\Service\WechatBot\SendMessage\MessageFormat\ImageInterface;
use App\Service\WechatBot\SendMessage\MessageFormat\TextInterface;
use App\Service\WechatBot\SendMessage\MessageFormat\VideoInterface;
use App\Service\WechatBot\SendMessage\MessageFormat\VoiceInterface;
use App\Service\WechatBot\ServiceProviderInterface;

class User implements UserInterface
{
    use UserInfo;

    public function __construct(
        protected array $data,
        protected ?ServiceProviderInterface $serviceProvider,
        protected ?GroupListInterface $groupList = null,
        protected ?FriendInterface $friend = null,
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

    public function setFriend(?FriendInterface $friend): void
    {
        $this->friend = $friend;
    }

    public function getFriend(): ?FriendInterface
    {
        return $this->friend;
    }

    public function setAddressList(AddressListInterface $addressList)
    {
        $this->addressList = $addressList;
    }

    public function getAddressList(): AddressListInterface
    {
        return $this->addressList;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function send(FriendInterface|GroupInterface $to, TextInterface $text)
    {
        $this->serviceProvider->getSendMessageManager()->send($to, $text);
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
}