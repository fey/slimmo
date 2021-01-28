<?php

require __DIR__ . '/vendor/autoload.php';

$builder = new DI\ContainerBuilder();
$builder->addDefinitions(__DIR__ . '/src/config.php');
$container = $builder->build();

register_shutdown_function(static function () use ($container) {
    $logger = $container->get('doctrine.logger');
    foreach ($logger->queries as $current) {
        error_log(sprintf(
            'query: %s, params: [%s]',
            $current['sql'],
            implode((array)$current['params'])
        ), 4);
    }

});

return $container;