<?php

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

$container = (require __DIR__ . '/config/bootstrap.php')->getContainer();

return ConsoleRunner::createHelperSet($container->get(EntityManagerInterface::class));
