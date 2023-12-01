<?php

namespace App\Service\WechatBot\Exceptions;

use Throwable;

class ConfirmLoginException extends \Exception {

    public function __construct(protected string $verifyCode,string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function getVerifyCode(): string
    {
        return $this->verifyCode;
    }
}