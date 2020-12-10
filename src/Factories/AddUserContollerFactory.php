<?php

namespace App\Factories;

use App\Controllers\AddUserController;
use Psr\Container\ContainerInterface;

class AddUserControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $userModel = $container->get('UserModel');
        return new AddUserController($userModel);
    }
}