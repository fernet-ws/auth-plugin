<?php

declare(strict_types=1);

namespace AuthFernet;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Fernet\Core\PluginBootstrap;
use Fernet\Framework;

class Bootstrap extends PluginBootstrap
{
    public function install(Framework $framework): void
    {
    }

    public function setUp(Framework $framework): void
    {
    }
}
