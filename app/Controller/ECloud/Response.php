<?php

namespace App\Controller\ECloud;


use Hyperf\HttpServer\Response as BaseResponse;
use Psr\Http\Message\ResponseInterface;


class Response extends BaseResponse
{
    public function success(array $data = []): ResponseInterface
    {
        return $this->json(['code' => '1000', 'message' => 'success','data'=>$data]);
    }

    public function error(array $data = []): ResponseInterface
    {
        return $this->json(['code' => '1001', 'message' => 'error','data'=>$data]);
    }
}