<?php
namespace AuthExpressive\Factories;

use AuthExpressive\AuthExpressive;
use AuthExpressive\Controller\RememberTokenController;
use AuthExpressive\Interfaces\AuthenticationInterface;
use Psr\Container\ContainerInterface;

class RememberTokenControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new RememberTokenController(
            $container->get(AuthenticationInterface::class),
            $container->get('config')[AuthExpressive::class]['middleware']['attributeToRequest']
        );
    }
}
