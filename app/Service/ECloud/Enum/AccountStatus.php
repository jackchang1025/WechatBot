<?php

namespace App\Service\ECloud\Enum;

enum AccountStatus: string {
    case NORMAL = '0';
    case FROZEN = '1';
    case EXPIRED = '2';

    public function getDescription(): string {
        return match($this) {
            self::NORMAL => '账号正常',
            self::FROZEN => '账号冻结',
            self::EXPIRED => '账号到期',
        };
    }
}
