<?php

declare(strict_types=1);

namespace App\Request;

use App\Service\ECloud\Enum\Proxy;
use Hyperf\Validation\Request\FormRequest;
use Hyperf\Validation\Rule;

class LoginRequest extends FormRequest
{
    protected array $scenes = [
        'login'            => ['account', 'password'],
        'getQRCode'        => ['wcId', 'proxy', 'proxyIp', 'proxyUser', 'proxyPassword'],
        'getIPadLoginInfo' => ['wId'],
    ];

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'account'       => 'required|in:admin',
            'password'      => 'required|in:admin',
            'wcId'          => 'string',
            'wId'           => 'required',
            'proxyIp'       => 'ipv4',
            'proxyUser'     => 'alpha_dash',
            'proxyPassword' => 'alpha_dash',
            'proxy'         => ['required', Rule::in(Proxy::getValues())],
        ];
    }
}
