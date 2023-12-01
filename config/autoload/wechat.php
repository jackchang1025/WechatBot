<?php

use App\Service\Xbot\XBotService;
use function Hyperf\Support\env;

return [
    'default' => env('WECHAT_PLATFORM', 'ecloud'),
    'http_callback_port' => 9502,
    'http_callback_host' => '0.0.0.0',
    'stores' => [
        'xbot'      => [
            'driver' => XBotService::class,
        ],
        'wechatdoc' => [
            'driver' => '',
            // Wechatdoc 平台的具体配置
        ],
        'ecloud'    => [
            'driver' => '',
            'account'           => 'admin',
            'password'          => 'admin',
            'base_uri'          => 'http://127.0.0.1:9501/ecloud',
            'proxy'             => '15',
            'proxyIp'           => '127.0.0.1',
            'proxyUser'         => 'proxyUser',
            'proxyPassword'     => 'proxyPassword',
            'http_callback_url' => '/setHttpCallbackUrl',
            // Ecloud 平台的具体配置
        ],
    ],

    'Authorization' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJwYXNzd29yZCI6ImUxMGFkYzM5NDliYTU5YWJiZTU2ZTA1N2YyMGY4ODNlYXZ1cHE9SGNTNXQwKGJvJiIsImlzcyI6InhpbmdzaGVuZyIsImFjY291bnQiOiIxMjM0NTY3ODkxMCJ9.x9bT9wDPAwGhJg7rTo0k4I0FlteKqK4AW7G9FsANgce',
];
