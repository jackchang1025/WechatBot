<?php

namespace App\Controller\ECloud;

use App\Controller\AbstractController;
use App\Request\LoginRequest;
use Faker\Factory;
use Faker\Generator;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Validation\Annotation\Scene;
use Psr\Http\Message\ResponseInterface;


class LoginController extends AbstractController
{

    protected Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('zh_CN');
    }

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

    #[Scene(scene: 'getQRCode')]
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

        //wcId	string	微信id
        //(唯一值）
        //nickName	string	昵称
        //deviceType	string	扫码的设备类型
        //uin	int	识别码
        //headUrl	string	头像url
        //wAccount	string	手机上显示的微信号
        //（用户若手机改变微信号，本值会变）
        //sex	int	性别
        //mobilePhone	string	绑定手机
        //status	string	保留字段

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