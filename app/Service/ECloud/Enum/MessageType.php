<?php

namespace App\Service\ECloud\Enum;

enum MessageType:string
{
    case Text = '60001';

    case Image = '60002';

//    case Video = '60003';
//
//    case Voice = '60004';

    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}