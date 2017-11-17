<?php
namespace AuthExpressive\Middleware\Factory;

use AuthExpressive\AuthExpressive;
use AuthExpressive\Interfaces\AuthProviderInterface;
use AuthExpressive\Middleware\MeMiddleware;
use Psr\Container\ContainerInterface;

class MeMiddlewareFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new MeMiddleware(
            $container->get(AuthProviderInterface::class),
            $container->get('config')[AuthExpressive::class]['middleware']
        );
    }
}
