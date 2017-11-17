<?php
namespace AuthExpressive\Factories;

use AuthExpressive\AuthExpressive;
use AuthExpressive\Controller\LoginController;
use AuthExpressive\Interfaces\AuthenticationInterface;
use Illuminate\Validation\Factory;
use Psr\Container\ContainerInterface;

class LoginControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new LoginController(
            $container->get(AuthenticationInterface::class),
            $container->get(Factory::class),
            $container->get('config')[AuthExpressive::class]['middleware']['expireIn']
        );
    }
}
