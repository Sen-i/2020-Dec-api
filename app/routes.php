<?php
declare(strict_types=1);

use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->addBodyParsingMiddleware();
    $container = $app->getContainer();

    $app->get('/users', 'GetAllUsersController');
    $app->post('/user', 'AddUserController');

    $app->put('/user/{email}', 'EditUserController');
    $app->delete('/user/{email}', 'DeleteUserController');

    $app->get('/', function ($request, $response, $args) use ($container) {
        $renderer = $container->get('renderer');
        return $renderer->render($response, "index.php", $args);
    });

};
