<?php
namespace AuthExpressive\Middleware\Factory;

use AuthExpressive\AuthExpressive;
use AuthExpressive\Interfaces\TokenInterface;
use AuthExpressive\Middleware\JwtMiddleware;
use Psr\Container\ContainerInterface;

class JwtMiddlewareFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config')[AuthExpressive::class];
        return new JwtMiddleware(
            $container->get(TokenInterface::class),
            $config['attributeToJwt'],
            $config['middleware']
        );
    }
}
