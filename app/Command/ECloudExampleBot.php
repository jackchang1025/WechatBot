<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\ECloud\ExampleServiceProviderAProvider;
use App\Service\ECloud\Login\LoginHandle;
use App\Service\WechatBot\Middleware\ImageMessageMiddleware;
use App\Service\WechatBot\Middleware\MessageMiddleware;
use App\Service\WechatBot\Middleware\Middleware;
use App\Service\WechatBot\Middleware\TextMessageMiddleware;
use App\Service\WechatBot\Server;
use App\Service\WechatBot\WechatBot;
use Hyperf\Command\Command as HyperfCommand;
use Hyperf\Command\Annotation\Command;
use Hyperf\Contract\ConfigInterface;
use Psr\Container\ContainerInterface;

#[Command]
class ECloudExampleBot extends HyperfCommand
{
    public function __construct(
        protected ContainerInterface $container,
        protected LoginHandle $loginHandle,
        protected ConfigInterface $config
    ) {
        parent::__construct('ecloud:run');
    }

    public function configure()
    {
        parent::configure();
        $this->setDescription('Hyperf Demo Command');
    }

    public function handle()
    {
        $exampleServiceProviderAProvider = new ExampleServiceProviderAProvider(
            $this->config->get('wechat.stores.ecloud')
        );
        $middleware                      = new Middleware();
        $middleware->setMiddlewares([
            new MessageMiddleware(),
            new TextMessageMiddleware(),
            new ImageMessageMiddleware(),
        ]);
        $wechatBot = new WechatBot($exampleServiceProviderAProvider, $this->loginHandle, $middleware);

        $Server = new Server(
            $wechatBot,
            $this->config->get('wechat.http_callback_host'),
            $this->config->get('wechat.http_callback_port')
        );
        $Server->start();
    }
}
