<?php
namespace AuthExpressive\Factories;

use AuthExpressive\AuthExpressive;
use AuthExpressive\AuthProvider;
use AuthExpressive\Interfaces\DatabaseInterface;
use AuthExpressive\Interfaces\StorageInterface;
use AuthExpressive\Interfaces\TokenInterface;
use Psr\Container\ContainerInterface;

class AuthProviderFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $authProvider = new AuthProvider();
        $authProvider->setDatabase($container->get(DatabaseInterface::class));
        $authProvider->setStorage($container->get(StorageInterface::class));
        $authProvider->setTokenDriver($container->get(TokenInterface::class));
        $authProvider->setTtl($container->get('config')[AuthExpressive::class]['middleware']['expireIn']);
        $authProvider->setPrefixStorage($container->get('config')[AuthExpressive::class]['prefixStorage']);
        return $authProvider;
    }
}
