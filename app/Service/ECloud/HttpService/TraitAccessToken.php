<?php

namespace App\Service\OneBotECloud\HttpService;


use App\Service\ECloud\Enum\AccountStatus;
use App\Service\WechatBot\Exceptions\AccountStatusException;
use InvalidArgumentException;
use Illuminate\Http\Client\Response;

trait TraitAccessToken
{
    protected ?string $accessToken = null;

    public function getAccessToken(): string
    {
        if ($this->accessToken) {
            return $this->accessToken;
        }

        $this->getHttpClient()
            ->setResponseMiddleware(function (Response $response, $next) {

                if ($response->object()->Authorization === null) {
                    throw new InvalidArgumentException('Authorization is null');
                }

                if ($response->object()->status != AccountStatus::NORMAL->value) {
                    $status = AccountStatus::from($response->object()->status);
                    throw new AccountStatusException($status->getDescription());
                }

                $this->setAccessToken($response->object()->Authorization);

                return $next($response);
            })->post('/member/login', [
                'form_params' => [
                    'account'  => $this->config->get('account'),
                    'password' => $this->config->get('password'),
                ],
            ]);

        return $this->accessToken;
    }

    public function setAccessToken(string $accessToken): void
    {
        $this->accessToken = $accessToken;
    }
}