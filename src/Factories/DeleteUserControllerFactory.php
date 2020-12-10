<?php

namespace App\Factories;

use App\Controllers\DeleteUserController;
use Psr\Container\ContainerInterface;

class DeleteUserControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $userModel = $container->get('UserModel');
        return new DeleteUserController($userModel);
    }
}