<?php

namespace App\Factories;

use Psr\Container\ContainerInterface;
use App\Controllers\GetAllUsersController;

class GetAllUsersControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $userModel = $container->get('UserModel');
        return new GetAllUsersController($userModel);
    }
}