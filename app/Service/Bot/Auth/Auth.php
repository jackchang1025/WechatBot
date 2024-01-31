<?php

namespace App\Service\Bot\Auth;

use App\Service\Bot\Auth\Action\ConfirmLoginAction;
use App\Service\Bot\BotFactory;
use Psr\Container\ContainerInterface;
use Weijiajia\Bot\BotManager;
use Weijiajia\OneBot\Action\Action;
use Weijiajia\OneBot\Action\ActionResponse;

class Auth
{

    public function __construct(protected ContainerInterface $container)
    {
    }

    public function confirmLogin(string $userId,?string $device = null): ActionResponse
    {
        $bot = BotFactory::create($userId,$device);

        $result = $bot->handleAction(new ConfirmLoginAction($bot->getRepository()));
        $bot->getRepository()->update($result);

        /**
         * @var BotManager $botManager
         */
        $botManager = $this->container->get('BotManager');
        $botManager->addBot($bot);

        //初始化通讯录
        return $bot->handleAction(new Action('getContact',$bot->getRepository()));
    }

    public function initContact(string $userId)
    {
        /**
         * @var BotManager $botManager
         */
        $botManager = $this->container->get('BotManager');
        $bot = $botManager->getBot($userId);

        $bot->handleAction(new Action('getContact',$bot->getRepository()));

    }
}