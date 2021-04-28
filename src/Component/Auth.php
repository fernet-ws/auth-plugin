<?php

declare(strict_types=1);

namespace AuthFernet\Component;

use Fernet\StatefulComponent;
use Fernet\UniqueComponent;
use Fernet\Config;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use AuthFernet\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class Auth
{
    use StatefulComponent;
    use UniqueComponent;
    
    protected const REDIRECT_TO = '/';

    protected EntityRepository $repository;
    protected string $redirectTo;

    public function __construct(protected EntityManager $entityManager, Config $config) 
    {
        $this->unique();
        $userClass = $config->get('auth.userEntity', User::class);
        $this->initState(user: new $userClass, logged: false);
        $this->redirectTo = $config->get('auth.redirectTo') ?? static::REDIRECT_TO;
        $this->repository = $entityManager->getRepository($userClass);
    }

    public function validate(string $username, string $password) : bool 
    {
        $user = $this->repository->findOneBy(['username' => $username]);
        if ($user && password_verify($password, $user->passwordHash)) {
            $this->logged($user);
            return true;
        }
        return false;
    }

    public function logged(User $user): self 
    {
        $user->clean();
        $this->setState(user: $user, logged: true);
        return $this;
    }

    public function logout(): self
    {
        $this->setState(user: new User, logged: false);
        return $this;
    }

    public function isLogged(): bool
    {
        return (bool) $this->state->logged;
    }

    public function getUser(): User
    {
        return $this->state->user;
    }

    public function redirect(): Response
    {
        return new RedirectResponse($this->redirectTo);
    }

    public function __toString(): string
    {
        return '';
    }
}

