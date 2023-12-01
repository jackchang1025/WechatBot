<?php

namespace App\Service\WechatBot\Exceptions;

class ApiResponseException extends \Exception {
    private mixed $responseData;

    public function __construct($message, $code = 0, $responseData = null) {
        parent::__construct($message, $code);
        $this->responseData = $responseData;
    }

    public function getResponseData() {
        return $this->responseData;
    }
}