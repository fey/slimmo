<?php

require __DIR__ . '/vendor/autoload.php';

$builder = new DI\ContainerBuilder();
$builder->addDefinitions(__DIR__ . '/src/config.php');
$container = $builder->build();

return $container;