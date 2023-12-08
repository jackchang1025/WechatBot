<?php

namespace App\Service\WechatBot\SendMessage;

use App\Service\WechatBot\Friend\FriendInterface;
use App\Service\WechatBot\Group\GroupInterface;
use App\Service\WechatBot\SendMessage\MessageFormat\FileInterface;
use App\Service\WechatBot\SendMessage\MessageFormat\ImageInterface;
use App\Service\WechatBot\SendMessage\MessageFormat\TextInterface;
use App\Service\WechatBot\SendMessage\MessageFormat\VideoInterface;
use App\Service\WechatBot\SendMessage\MessageFormat\VoiceInterface;
use App\Service\WechatBot\User\UserInterface;

interface SendMessageManagerInterface
{
    public function send(UserInterface $user,FriendInterface|GroupInterface $to, TextInterface $text);

    public function sendFile(FriendInterface|GroupInterface $to, FileInterface $file);

    public function sendImage(FriendInterface|GroupInterface $to, ImageInterface $image);

    public function sendVoice(FriendInterface|GroupInterface $to, VoiceInterface $voice);

    public function sendVideo(FriendInterface|GroupInterface $to, VideoInterface $video);
}