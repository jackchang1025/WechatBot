<?php

namespace App\Service\WechatBot;

use App\Service\WechatBot\Middleware\Pipeline;
use App\Service\WechatBot\Middleware\TraitMiddleware;
use App\Service\WechatBot\ReceiveMessage\MessageFormat\MessageInterface;
use App\Service\WechatBot\User\UserInterface;
use Hyperf\Context\ApplicationContext;

class WechatBot implements WechatBotInterface
{
    use TraitMiddleware;

    protected MessageInterface $message;

    public function __construct(
        protected ServiceProviderInterface $serviceProvider,
        protected UserInterface $user,
    ) {

        $this->setPipeline(new Pipeline(ApplicationContext::getContainer()));
    }

    public function start()
    {
        $message = $this->getMessage();

        try {

            $this->receiveMessageHandle($message);

        } catch (\Exception $e) {

            $this->handleException();
        }
    }

    public function getUserManager(): UserInterface
    {
        return $this->user;
    }

    public function handleException()
    {
    }

    public function getMessage(): ReceiveMessage\MessageFormat\MessageInterface
    {
        $this->message ??= $this->serviceProvider->getMessage();

        return $this->message;
    }

    public function receiveMessageHandle(MessageInterface $message): mixed
    {
        $message->setUser($this->user->findUser($message->getFromUser()));
        return $this->thenHandle($message);
    }
}
