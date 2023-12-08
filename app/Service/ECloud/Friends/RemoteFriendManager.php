<?php
namespace App\Service\ECloud\Friends;

use App\Service\ECloud\HttpService;
use App\Service\WechatBot\Friend\RemoteFriendManagerInterface;

class RemoteFriendManager implements RemoteFriendManagerInterface
{

    public function __construct(protected HttpService $httpService)
    {
    }
}