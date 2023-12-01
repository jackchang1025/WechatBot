<?php

namespace App\Service\ECloud;

use App\Service\WechatBot\Exceptions\ApiResponseException;
use App\Service\WechatBot\Exceptions\ConfirmLoginException;
use Psr\Http\Message\ResponseInterface;

class ApiResponseHandler
{
    /**
     * @param ResponseInterface $response
     * @return array
     * @throws ApiResponseException|ConfirmLoginException
     */
    public static function handleResponse(ResponseInterface $response): array
    {
        $data = json_decode($response->getBody(), true);

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

        return $data['data'];
    }
}