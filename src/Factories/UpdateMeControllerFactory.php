<?php
namespace AuthExpressive\Factories;

use AuthExpressive\AuthExpressive;
use AuthExpressive\Controller\UpdateControllerMe;
use AuthExpressive\Controller\UpdateMeController;
use AuthExpressive\Interfaces\AuthenticationInterface;
use Illuminate\Validation\Factory;
use Psr\Container\ContainerInterface;

class UpdateMeControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new UpdateMeController(
            $container->get(AuthenticationInterface::class),
            $container->get(Factory::class),
            $container->get('config')[AuthExpressive::class]['middleware']['attributeToRequest']
            );
    }
}
