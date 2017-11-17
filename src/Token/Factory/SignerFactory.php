<?php
namespace AuthExpressive\Token\Factory;

use Lcobucci\JWT\Signer\Hmac\Sha256;
use Psr\Container\ContainerInterface;

class SignerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new Sha256();
    }
}
