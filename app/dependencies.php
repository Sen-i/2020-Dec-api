<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Slim\Views\PhpRenderer;

return function (ContainerBuilder $containerBuilder) {
    $container = [];

    $container[LoggerInterface::class] = function (ContainerInterface $c) {
        $settings = $c->get('settings');

        $loggerSettings = $settings['logger'];
        $logger = new Logger($loggerSettings['name']);

        $processor = new UidProcessor();
        $logger->pushProcessor($processor);

        $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
        $logger->pushHandler($handler);

        return $logger;
    };

    $container['renderer'] = function (ContainerInterface $c) {
        $settings = $c->get('settings')['renderer'];
        $renderer = new PhpRenderer($settings['template_path']);
        return $renderer;
    };

    $container['Database'] = new App\Utilities\Database();

    $container['UserModel'] = DI\factory('App\Factories\UserModelFactory');

    $container['AddUserController'] = DI\factory('App\Factories\AddUserControllerFactory');
    $container['GetAllUsersController'] = DI\factory('App\Factories\GetAllUsersControllerFactory');
    $container['EditUserController'] = DI\factory('\App\Factories\EditUserControllerFactory');
    $container['DeleteUserController'] = DI\factory('App\Factories\DeleteUserControllerFactory');

    $containerBuilder->addDefinitions($container);
};
