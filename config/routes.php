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

use App\Controller\ECloud\LoginController;
use App\Middleware\ECloud\AuthMiddleware;
use Hyperf\HttpServer\Router\Router;

Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\IndexController@index');

Router::get('/favicon.ico', function () {
    return '';
});






Router::addGroup('', function () {

    Router::post('/member/login', [LoginController::class, 'login']);


    Router::addGroup('', function () {

        Router::post('/iPadLogin', [LoginController::class, 'iPadLogin']);
        Router::post('/getIPadLoginInfo', [LoginController::class, 'getIPadLoginInfo']);

    }, ['middleware' => [AuthMiddleware::class]]);

});

