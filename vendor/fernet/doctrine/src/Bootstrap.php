<?php

declare(strict_types=1);

namespace DoctrineFernet;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Fernet\Core\PluginBootstrap;
use Fernet\Framework;
use Fernet\Core\Exception;

class Bootstrap extends PluginBootstrap
{
    private const ENTITY_PATH = '/src/Entity';
    private const LINK = 'https://github.com/pragmore/doctrine-fernet';
    private const CLI_CONFIG_FILE = 'cli-config.php';

    public function install(Framework $framework): void
    {
        // TODO: remove if when the install stops being called on every call
        if (!file_exists(self::CLI_CONFIG_FILE)) {
            copy(
                dirname(__DIR__) . DIRECTORY_SEPARATOR .  self::CLI_CONFIG_FILE, 
                $framework->getConfig('rootPath').DIRECTORY_SEPARATOR .self::CLI_CONFIG_FILE
            );
        }
    }

    public function setUp(Framework $framework): void
    {
        if (!isset($_ENV['DB_DRIVER'])) {
            throw new Exception("DB_DRIVER config is missing", 0, self::LINK);
        }

        $paths = [$framework->getConfig('rootPath').self::ENTITY_PATH];
        $isDevMode = $framework->getConfig('devMode');
        $dbParams = [ 
            'driver'   => $_ENV['DB_DRIVER'],
            'user'     => $_ENV['DB_USER'] ?? null,
            'password' => $_ENV['DB_PASSWORD'] ?? null,
            'dbname'   => $_ENV['DB_NAME'] ?? null,
            'host'     => $_ENV['DB_HOST'] ?? null,
            'path'     => $_ENV['DB_PATH'] ?? null,
        ];
        $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
        $entityManager = EntityManager::create($dbParams, $config);
        $framework->getContainer()->add(EntityManager::class, $entityManager);
    }
}
