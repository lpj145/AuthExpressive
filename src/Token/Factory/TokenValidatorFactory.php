<?php
namespace AuthExpressive\Token\Factory;

use Lcobucci\JWT\Validation\Validator;
use Psr\Container\ContainerInterface;

class TokenValidatorFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new Validator();
    }
}
