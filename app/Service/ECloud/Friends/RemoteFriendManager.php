<?php
namespace App\Service\ECloud\Friends;

use App\Service\OneBotECloud\HttpService\TraitHttpClient;
use App\Service\WechatBot\Friend\RemoteFriendManagerInterface;

class RemoteFriendManager implements RemoteFriendManagerInterface
{

    public function __construct(protected TraitHttpClient $httpService)
    {
    }
}