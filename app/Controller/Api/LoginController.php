<?php

namespace App\Controller\Api;


use app\Model\User;
use App\Request\LoginRequest;
use App\Service\Bot\Auth\Action\ConfirmLoginAction;
use App\Service\Bot\Auth\Auth;
use App\Service\Bot\BotFactory;
use Hyperf\Contract\ContainerInterface;
use Hyperf\HttpServer\Contract\RequestInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Http\Message\ResponseInterface;
use Weijiajia\Bot\Bot;
use Weijiajia\Bot\BotManager;
use Weijiajia\OneBot\Action\Action;

class LoginController
{

    public function __construct(protected Auth $auth)
    {
    }

    public function getQrCode(RequestInterface $request, ResponseInterface $response)
    {
        $bot = BotFactory::create($request->input('user_id'),$request->input('device'));
        $result = $bot->handleAction(new Action('getQrCode',$bot->getRepository()));
        $response->json($result);
    }

    public function confirmLogin(RequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $result = $this->auth->confirmLogin($request->input('user_id'));

        return $response->json($result);
    }

    public function initContact(RequestInterface $request, ResponseInterface $response)
    {
        $result = $this->auth->confirmLogin($request->input('user_id'));
    }
}