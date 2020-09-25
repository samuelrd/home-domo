<?php

use App\Controllers\HomeController;
use App\Controllers\SwitchController;
use App\Utility\Configuration;
use DI\ContainerBuilder;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\Setup;
use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

$containerBuilder = new ContainerBuilder();

$containerBuilder->addDefinitions([
    // dependencies
    EntityManagerInterface::class => function (): EntityManager {
        $config = Setup::createAnnotationMetadataConfiguration([__DIR__.'/../src/Domain/'], true);
        $config->setMetadataDriverImpl(
            new AnnotationDriver(new AnnotationReader, [__DIR__.'/../src/Domain/'])
        );

        $config->setMetadataCacheImpl(
            new FilesystemCache(__DIR__.'/../var/cache/doctrine')
        );

        return EntityManager::create([
            'driver' => $_ENV['DB_DRIVER'],
            'host' => $_ENV['DB_HOST'],
            'port' => $_ENV['DB_PORT'],
            'dbname' => $_ENV['DB_NAME'],
            'user' => $_ENV['DB_USER'],
            'password' => $_ENV['DB_PASSWORD'],
        ], $config);
    },

    // Twig templates
    Twig::class => function () {
        return Twig::create(__DIR__ . '/../templates', ['cache' => false]);
    },

    // Configuration
    Configuration::class => new Configuration([
        // python scripts path
        'scripts_path' => __DIR__ . '/../bin/scripts'
    ])
]);

// Build PHP-DI Container instance
$container = $containerBuilder->build();

// Instantiate the app
AppFactory::setContainer($container);

$app = AppFactory::create();

// Add middleware
$app->addBodyParsingMiddleware();
$app->add(TwigMiddleware::createFromContainer($app, Twig::class));

// Register routes
$app->post('/switch/{power}', SwitchController::class . ':switch');
$app->get('/', HomeController::class . ':home');

return $app;
