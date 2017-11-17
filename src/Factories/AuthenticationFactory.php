<?php
namespace AuthExpressive\Factories;

use AuthExpressive\Authentication;
use AuthExpressive\Interfaces\AuthProviderInterface;
use Psr\Container\ContainerInterface;

class AuthenticationFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $authentication = new Authentication();
        $authentication->setProvider($container->get(AuthProviderInterface::class));
        return $authentication;
    }
}
