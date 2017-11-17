<?php
namespace AuthExpressive\Factories;

use AuthExpressive\AuthExpressive;
use AuthExpressive\Controller\MeController;
use AuthExpressive\Interfaces\AuthProviderInterface;
use Psr\Container\ContainerInterface;

class MeControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new MeController(
            $container->get(AuthProviderInterface::class),
            $container->get('config')[AuthExpressive::class]['middleware']['attributeToRequest']
        );
    }
}
