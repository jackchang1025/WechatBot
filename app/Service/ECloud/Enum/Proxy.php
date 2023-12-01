<?php

namespace App\Service\ECloud\Enum;

enum Proxy:int
{
    //1：北京 2：天津 3：上海 4：重庆 5：河北
    //6：山西 7：江苏 8：浙江 9：安徽 10：福建
    //11：江西 12：山东 13：河南 14：湖北 15：湖南
    //16：广东 17：海南 18：四川 20：陕西

    case BEIJING = 1;
    case TIANJIN = 2;
    case SHANGHAI = 3;
    case CHONGQING = 4;
    case HEBEI = 5;
    case SHANXI = 6;
    case JIANGSU = 7;
    case ZHEJIANG = 8;
    case ANHUI = 9;
    case FUJIAN = 10;
    case JIANGXI = 11;
    case SHANDONG = 12;
    case HENAN = 13;
    case HUBEI = 14;
    case HUNAN = 15;
    case GUANGDONG = 16;
    case HAINAN = 17;
    case SINGAPORE = 18;
    case SHANGXI = 20;
    case SICHUAN = 21;
    case HUANAN = 22;

    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}