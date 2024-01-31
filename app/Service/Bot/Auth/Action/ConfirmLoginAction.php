<?php

namespace App\Service\Bot\Auth\Action;

use Weijiajia\OneBot\Action\Action;
use Weijiajia\OneBot\Self\SelfInterface;

class ConfirmLoginAction extends Action
{

    public function __construct(SelfInterface $self, array $params = [], ?string $echo = null)
    {
        parent::__construct('login', $self, $params, $echo);
    }
}