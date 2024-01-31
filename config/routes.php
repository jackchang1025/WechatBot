<?php

declare(strict_types=1);

/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

use App\Controller\ECloud\AddressController;
use App\Controller\ECloud\CallbackController;
use App\Controller\ECloud\LoginController;
use App\Controller\WebSocketController;
use App\Middleware\ECloud\AuthMiddleware;
use App\Middleware\ECloud\MessageFormatMiddleware;
use Hyperf\HttpServer\Router\Router;

Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\IndexController@index');

Router::get('/favicon.ico', function () {
    return '';
});

Router::addGroup('/api', function () {

    Router::get('/login', [LoginController::class, 'login']);

});

Router::addGroup('', function () {

    Router::post('/member/login', [LoginController::class, 'login']);

    Router::post('/setHttpCallbackUrl', [CallbackController::class, 'index']);

    Router::addGroup('', function () {

        Router::post('/iPadLogin', [LoginController::class, 'iPadLogin']);
        Router::post('/getIPadLoginInfo', [LoginController::class, 'getIPadLoginInfo']);

        Router::post('/initAddressList', [AddressController::class, 'initAddressList']);
        Router::post('/getAddressList', [AddressController::class, 'getAddressList']);

    }, ['middleware' => [AuthMiddleware::class]]);

});

Router::addGroup('/drive',function (){
    Router::addGroup('/ecloud',function (){

    },['middleware' => [MessageFormatMiddleware::class]]);

    Router::addGroup('/http',function (){

    },['middleware' => [MessageFormatMiddleware::class]]);
});


Router::addServer('ws', function () {
    Router::get('/', [WebSocketController::class, 'index']);
});





