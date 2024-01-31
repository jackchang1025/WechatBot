<?php

namespace App\Service\WechatBot;

use Illuminate\Http\Client\Response as IlluminateResponse;

class Response implements ResponseInterface
{

    public function __construct(public IlluminateResponse $response)
    {
    }

    public function toArray(): array
    {
        return $this->response->collect()->toArray();
    }

    public function toObject(): object
    {
        return $this->response->object();
    }
}
