<?php

use App\Application\Commands\ScheduleRunCommand;
use App\Controllers\EventController;
use App\Controllers\HomeController;
use App\Controllers\SocketController;
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

    // Register commands
    'commands' => [
        ScheduleRunCommand::class
    ],

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

// Events
$app->get('/events/edit[/{id}]', EventController::class . ':edit');
$app->get('/events', EventController::class . ':list');
$app->get('/events/{id}', EventController::class . ':get');
$app->post('/events', EventController::class . ':store');
$app->put('/events/{id}', EventController::class . ':update');
$app->delete('/events/{id}', EventController::class . ':delete');

// Socket
$app->get('/sockets/edit[/{id}]', SocketController::class . ':edit');
$app->get('/sockets', SocketController::class . ':list');
$app->get('/sockets/{id}', SocketController::class . ':get');
$app->post('/sockets', SocketController::class . ':store');
$app->put('/sockets/{id}', SocketController::class . ':update');
$app->delete('/sockets/{id}', SocketController::class . ':delete');

return $app;
