<?php

namespace App\Service\ECloud;

use App\Service\WechatBot\Exceptions\ApiResponseException;
use App\Service\WechatBot\Exceptions\ConfirmLoginException;
use App\Service\WechatBot\ResponseInterface;
use Illuminate\Http\Client\Response;

class ApiResponseHandler
{
    /**
     * @param Response $response
     * @return Response
     * @throws ApiResponseException
     * @throws ConfirmLoginException
     */
    public static function handleResponse(Response $response): Response
    {
        $data = $response->object();

        if (!$data || !isset($data['code']) || !isset($data['data'])) {
            throw new ApiResponseException('响应格式错误或缺少必要字段', 0);
        }

        if ($data['message'] === "请在ipad上输入验证码") {
            // 需要输入验证码，可能需要外部逻辑处理
            throw new ConfirmLoginException($data['verifyCode'], $data['message']);
        }

        if ($data['code'] !== '1000') {
            throw new ApiResponseException($data['message'] ?? '未知错误', $data['code'], $data);
        }

        return $response;
    }
}