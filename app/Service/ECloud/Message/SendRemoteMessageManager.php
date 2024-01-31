<?php

namespace App\Service\ECloud\Message;

use App\Service\ECloud\ConfigTrait;
use App\Service\OneBotECloud\HttpService\TraitHttpClient;
use App\Service\WechatBot\Friend\FriendInterface;
use App\Service\WechatBot\Group\GroupInterface;
use App\Service\WechatBot\SendMessage\MessageFormat\FileInterface;
use App\Service\WechatBot\SendMessage\MessageFormat\ImageInterface;
use App\Service\WechatBot\SendMessage\MessageFormat\TextInterface;
use App\Service\WechatBot\SendMessage\MessageFormat\VideoInterface;
use App\Service\WechatBot\SendMessage\MessageFormat\VoiceInterface;
use App\Service\WechatBot\SendMessage\SendMessageManagerInterface;
use App\Service\WechatBot\User\UserInterface;

class SendRemoteMessageManager implements SendMessageManagerInterface
{
    public function __construct(protected TraitHttpClient $httpService,protected ConfigTrait $config)
    {
    }

    public function send(UserInterface $user, FriendInterface|GroupInterface $to, TextInterface $text)
    {
        $response = $this->httpService->post('/member/login', [
            'wId'     => $this->config->get('wId'),
            'wcId'    => $to->getGroupId() ?? $to->getWechatId(),
            'content' => $text->getContent(),
        ]);
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