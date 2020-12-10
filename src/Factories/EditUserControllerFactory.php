<?php

namespace App\Factories;

use Psr\Container\ContainerInterface;
use App\Controllers\EditUserController;

class EditUserControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $userModel = $container->get('UserModel');

        return new EditUserController($userModel);
    }
}