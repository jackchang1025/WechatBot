<?php

declare(strict_types=1);

namespace App\Controller\ECloud;

use App\Request\LoginRequest;
use Faker\Generator;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Validation\Annotation\Scene;
use Psr\Http\Message\ResponseInterface;

class AddressController
{
    #[Inject]
    protected Generator $faker;

    #[Scene(scene: 'initAddressList')]
    public function initAddressList(LoginRequest $request, Response $response): ResponseInterface
    {
        return $response->success($request->all());
    }

    #[Scene(scene: 'getAddressList')]
    public function getAddressList(LoginRequest $request, Response $response): ResponseInterface
    {
        return $response->success([
            "chatrooms" => [
                "",
            ],
            "friends"   => [
                "",
            ],
            "ghs"       => [
                "",
            ],
            "others"    => [
                "",
            ],
        ]);
    }
}
