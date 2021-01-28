<?php

use DI\Container;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

use function DI\get;

return [
    'doctrine.annotationMetadataConfiguration' => [__DIR__ . '/Entities'],
    'doctrine.isDevMode' => true,
    'doctrine.proxyDir' => null,
    'doctrine.cache' => null,
    'doctrine.useSimpleAnnotationReader' => false,
    'doctrine.logger' => \DI\create(\Doctrine\DBAL\Logging\DebugStack::class),
    'doctrine.config' => static function (Container $c): Configuration {
        $logger = $c->get('doctrine.logger');
        $config = Setup::createAnnotationMetadataConfiguration(
            $c->get('doctrine.annotationMetadataConfiguration'),
            $c->get('doctrine.isDevMode'),
            $c->get('doctrine.proxyDir'),
            $c->get('doctrine.cache'),
            $c->get('doctrine.useSimpleAnnotationReader')
        );

        $config->setSQLLogger($logger);

        return $config;
    },
    'doctrine.connection' => [
        'driver' => 'pdo_sqlite',
        'path' => __DIR__ . '/../database/db.sqlite',
    ],
    EntityManager::class => DI\factory([EntityManager::class, 'create'])
        ->parameter('connection', get('doctrine.connection'))
        ->parameter('config', get('doctrine.config')),
];
