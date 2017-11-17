<?php
namespace AuthExpressive\Token\Factory;

use AuthExpressive\AuthExpressive;
use Lcobucci\JWT\Signer\Key;
use Psr\Container\ContainerInterface;

class KeyFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new Key($this->getSecret($container));
    }

    protected function getSecret(ContainerInterface $container)
    {
        $secret = $container->get('config')[AuthExpressive::class]['secret'];
        if (is_null($secret)) {
            throw new \ErrorException('\'secret\' on '.AuthExpressive::class.' config not can be null, please update it to a security key!');
        }
        return $secret;
    }
}
