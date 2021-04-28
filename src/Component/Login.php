<?php

declare(strict_types=1);

namespace AuthFernet\Component;

use Symfony\Component\HttpFoundation\Response;
use Fernet\Config;

class Login
{
    protected const INVALID_MESSAGE = 'You have entered an invalid username or password';
    public string $username = '';
    public string $password = '';
    protected string $invalidMessage;
    protected string $errorMessage = '';

    public function __construct(protected Auth $auth, private Config $config)
    {
        $this->invalidMessage = $config->get('auth.invalidaMessage', static::INVALID_MESSAGE);
    }

    public function handle() : ?Response
    {
        if ($this->auth->validate($this->username, $this->password)) {
            return $this->auth->redirect();
        }
        $this->errorMessage = $this->invalidMessage;
        return null;
    }

    public function __toString(): string
    {
        ob_start(); ?>

    <form @onSubmit="handle" class="fernet_auth_component_login">
        <?php if ($this->errorMessage): ?>
        <p><?= $this->errorMessage ?></p>
        <?php endif; ?>
        <p>
            <label for="login_username">User</label>
            <input @bind="username" id="login_username" />
        </p>
        <p>
            <label for="login_password">Password</label>
            <input type="password" @bind="password" for="login_password" />
        </p>
        <p>
            <button>Login</button>
        </p>
    </form>

<?php
        return ob_get_clean();
    }
}
