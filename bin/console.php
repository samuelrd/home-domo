<?php
// application.php

require __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Console\Application;

$application = new Application();

/** @var ContainerInterface $container */
$container = (require __DIR__ . '/../config/bootstrap.php')->getContainer();
$commands = $container->get('commands');

$application = new Application();

foreach ($commands as $class) {
    $application->add($container->get($class));
}

$application->run();
