<?php

declare(strict_types=1);

namespace App\Command;

use Hyperf\Command\Command as HyperfCommand;
use Hyperf\Command\Annotation\Command;
use Hyperf\Di\Annotation\Inject;
use Hyperf\WebSocketClient\ClientFactory;
use Hyperf\WebSocketClient\Frame;
use Psr\Container\ContainerInterface;

#[Command]
class WebsocketClient extends HyperfCommand
{
    #[Inject]
    protected ClientFactory $clientFactory;

    public function __construct(protected ContainerInterface $container)
    {
        parent::__construct('websocket:client');
    }

    public function configure()
    {
        parent::configure();
        $this->setDescription('Hyperf Demo Command');
    }

    public function handle()
    {

        // 对端服务的地址，如没有提供 ws:// 或 wss:// 前缀，则默认补充 ws://
        $host = 'ws://127.0.0.1:9502';
        // 通过 ClientFactory 创建 Client 对象，创建出来的对象为短生命周期对象
        $client = $this->clientFactory->create($host,false);
        // 向 WebSocket 服务端发送消息
        $client->push('HttpServer 中使用 WebSocket Client 发送数据。');
        // 获取服务端响应的消息，服务端需要通过 push 向本客户端的 fd 投递消息，才能获取；以下设置超时时间 2s，接收到的数据类型为 Frame 对象。

        while (true) {
            $frame = $client->recv();
            if ($frame === false || $frame == '') {
                echo "连接断开\n";
                $client->close();
                break;
            } elseif ($frame->opcode == WEBSOCKET_OPCODE_PING) {
                $client->push('', WEBSOCKET_OPCODE_PONG);
            } elseif ($frame->opcode == WEBSOCKET_OPCODE_PONG) {
                // 处理 PONG 响应
            } else {
                echo "接收到消息: {$frame->data}\n";
                // 处理收到的消息
            }
        }
    }
}
