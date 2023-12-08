<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\ECloud\ExampleServiceProviderAProvider;
use App\Service\WechatBot\BotManager;
use Hyperf\Command\Command as HyperfCommand;
use Hyperf\Command\Annotation\Command;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Contract\ContainerInterface;

#[Command]
class ECloudExampleBot extends HyperfCommand
{
    /**
     * @param ContainerInterface $container
     * @param BotManager $botManager
     */
    public function __construct(
        protected ContainerInterface $container,
        protected BotManager $botManager,
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

        $config = $this->container->get(ConfigInterface::class);

        $bot = BotManager::buildBot(
            new ExampleServiceProviderAProvider($config->get('wechat.stores.ecloud'))
        );

        $bot->start();

        $getWechatId = $bot->getUserManager()->getUserManager()->getWechatId();
        if ($getWechatId) {
            $this->botManager->createBot($getWechatId, $bot);
        }

        $wechatBot = $this->botManager->findBotByWcId($getWechatId);
        var_dump($wechatBot->getUserManager()->getUserManager()->getNickName(),$this->botManager->hGetAll());
    }
}
