<?php

declare(strict_types=1);

namespace AuthFernet\Component;

use Symfony\Component\HttpFoundation\Response;

class Logout
{
    public function __construct(protected Auth $auth)
    {
    }

    public function handle(): Response
    {
        return $this->auth->logout()->redirect();
    }

    public function __toString(): string
    {
        return "<a @onClick=\"handle\">{$this->childContent}</a>";
    }
}
