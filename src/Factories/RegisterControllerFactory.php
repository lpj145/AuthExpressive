<?php
namespace AuthExpressive\Factories;

use AuthExpressive\Controller\RegisterController;
use AuthExpressive\Interfaces\AuthenticationInterface;
use Illuminate\Validation\Factory;
use Psr\Container\ContainerInterface;

class RegisterControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new RegisterController($container->get(AuthenticationInterface::class), $container->get(Factory::class));
    }
}
