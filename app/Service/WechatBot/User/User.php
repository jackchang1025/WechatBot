<?php

namespace App\Service\WechatBot\User;

use App\Service\WechatBot\Address\AddressListInterface;
use App\Service\WechatBot\Enum\UserStatus;
use App\Service\WechatBot\Event\GetQRCodeEvent;
use App\Service\WechatBot\Event\GetUserInfoEvent;
use App\Service\WechatBot\Friend\FriendInterface;
use App\Service\WechatBot\Friend\Friend;
use App\Service\WechatBot\Group\Group;
use App\Service\WechatBot\Group\GroupInterface;
use App\Service\WechatBot\RepositoryI\RepositoryInterface;
use App\Service\WechatBot\RepositoryI\UserRepositoryInterface;
use App\Service\WechatBot\SendMessage\MessageFormat\FileInterface;
use App\Service\WechatBot\SendMessage\MessageFormat\ImageInterface;
use App\Service\WechatBot\SendMessage\MessageFormat\TextInterface;
use App\Service\WechatBot\SendMessage\MessageFormat\VideoInterface;
use App\Service\WechatBot\SendMessage\MessageFormat\VoiceInterface;
use App\Service\WechatBot\ServiceProviderInterface;
use App\Service\WechatBot\User\Login\LoginManager;
use Illuminate\Contracts\Events\Dispatcher;

class User implements UserInterface
{
    use LoginManager;

    protected UserRepositoryInterface $repository;

    public function __construct(
        protected ServiceProviderInterface $serviceProvider,
        UserRepositoryInterface $repository,
        protected ?Dispatcher $dispatcher = null,
    ) {

        $this->setRepository($repository);
    }

    public function getRepository(): RepositoryInterface
    {
        return $this->repository;
    }

    public function setRepository(UserRepositoryInterface $repository): void
    {
        $this->repository = $repository;
        if ($this->repository->isLogin()){

            $this->serviceProvider->setInstanceId($this->getInstanceId());
            $this->serviceProvider->setWechatId($this->getWechatId());

        }else{

            $response = $this->getQRCode();
            $this->repository->updateInstanceId($response->getInstanceId());
            $this->serviceProvider->setInstanceId($response->getInstanceId());
            $this->dispatcher?->dispatch(new GetQRCodeEvent($response));

            $response = $this->getUserInfo();
            $this->repository->update([
                'nick_name'  => $response->getNickName(),
                'wechat_id'  => $response->getWechatId(),
                'device_ype' => $response->getDeviceType(),
                'head_url'   => $response->getHeadUrl(),
                'sex'        => $response->getSex(),
                'phone'      => $response->getPhone(),
                'status'     => UserStatus::LOGIN,
            ]);

            $this->serviceProvider->setWechatId($response->getWechatId());
            $this->dispatcher?->dispatch(new GetUserInfoEvent($this->repository));
        }
    }

    public function findUser(string $wechatId): UserInterface
    {
        $user = $this->repository->getUser($wechatId);

        if ($user === null) {
            throw new \Exception("用户不存在");
        }

        return $this->make($user);
    }

    public function make(UserRepositoryInterface $repository): UserInterface
    {
        return new User($this->serviceProvider, $repository);
    }


    public function getGroup(string $wechatId): GroupInterface
    {
        $group = $this->repository->getGroup($wechatId);

        //从接口获取好友信息
        $response = $this->serviceProvider->getRemoteFriendManager()->getFriend($wechatId);

        //判断缓存
        if ($group){
            //判断缓存数据与接口数据是否一致
            if (array_diff($group->toArray(), $response->toArray())){
                //缓存数据与接口数据不一致，更新缓存
                $this->repository->updateGroup($response->toArray());
            }
        }else{
            //缓存中不存在该好友信息，更新缓存
            $this->repository->createGroup($response->toArray());
        }
        return new Group($group);
    }

    public function setAddressList(AddressListInterface $addressList): void
    {
        $this->addressList = $addressList;
    }

    public function getAddressList(): AddressListInterface
    {
        return $this->repository->getAddressList();
    }

    public function send(FriendInterface|GroupInterface $to, TextInterface $text)
    {
        $this->serviceProvider->sendMessageManager($this, $to, $text);
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

    public function updateData(array $data): bool
    {
        return $this->repository->update($data);
    }

    public function isLogin(): bool
    {
        return $this->repository->isLogin();
    }
    public function getInstanceId(): ?string
    {
        return $this->repository->getInstanceId();
    }

    public function isOffline(): bool
    {
        return $this->repository->isOffline();
    }

    public function isNotLogin(): bool
    {
        return $this->repository->isOffline();
    }

    public function getStatus(): string
    {
        return $this->repository->getStatus();
    }

    public function updateStatus(string $status): bool
    {
        return $this->repository->updateStatus($status);
    }

    public function getFriend(string $wechatId): FriendInterface
    {
        //从缓存中获取好友信息
        $friend = $this->repository->getFriend($wechatId);

        //从接口获取好友信息
        $response = $this->serviceProvider->getRemoteFriendManager()->getFriend($wechatId);

        //判断缓存
        if ($friend) {
            //判断缓存数据与接口数据是否一致
            if (array_diff($friend->toArray(), $response->toArray())) {
                //缓存数据与接口数据不一致，更新缓存
                $this->repository->updateFriend($response->toArray());
            }
        } else {
            //缓存中不存在该好友信息，更新缓存
            $this->repository->createFriend($response->toArray());
        }

        return new Friend($response);
    }

    public function getWechatId(): string
    {
        return $this->repository->getWechatId();
    }

    public function getNickName(): string
    {
        return $this->repository->getNickName();
    }

    public function getDeviceType(): string
    {
        return $this->repository->getDeviceType();
    }

    public function getUin(): int
    {
        return $this->repository->getUin();
    }

    public function getHeadUrl(): string
    {
        return $this->repository->getHeadUrl();
    }

    public function getWAccount(): string
    {
        return $this->repository->getWAccount();
    }

    public function getSex(): int
    {
        return $this->repository->getSex();
    }

    public function getMobilePhone(): string
    {
        return $this->repository->getMobilePhone();
    }

}