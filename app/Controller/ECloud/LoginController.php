<?php

namespace App\Controller\ECloud;

use App\Request\LoginRequest;
use Faker\Generator;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Validation\Annotation\Scene;
use Psr\Http\Message\ResponseInterface;


class LoginController
{

    #[Inject]
    protected Generator $faker;

    #[Scene(scene: 'login')]
    public function login(LoginRequest $request, Response $response, ConfigInterface $config): ResponseInterface
    {
        $validated = $request->validated();

        return $response->success([
            "callbackUrl"   => $this->faker->imageUrl,
            "status"        => '0',
            "Authorization" => $config->get("wechat.Authorization"),
        ]);
    }

    #[Scene(scene: 'iPadLogin')]
    public function iPadLogin(LoginRequest $request, Response $response): ResponseInterface
    {
        $validated = $request->validated();

        return $response->success([
            "qrCodeUrl" => 'https://www.baidu.com',
            "wId"       => $this->faker->randomNumber(6),
        ]);
    }

    #[Scene(scene: 'getIPadLoginInfo')]
    public function getIPadLoginInfo(LoginRequest $request, Response $response): ResponseInterface
    {
        sleep(rand(5,10));

        return $response->success([
            "wcId" => $this->faker->uuid,
            "nickName"       => $this->faker->name(),
            "deviceType"     => $this->faker->randomElement(['ios', 'android']),
            "uin"            => $this->faker->randomNumber(6),
            "headUrl"        => $this->faker->imageUrl,
            "wAccount"       => $this->faker->phoneNumber(),
            "sex"            => $this->faker->randomElement([1, 2]),
            "mobilePhone"    => $this->faker->phoneNumber(),
        ]);
    }
}