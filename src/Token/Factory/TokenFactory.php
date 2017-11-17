<?php
namespace AuthExpressive\Token\Factory;

use AuthExpressive\AuthExpressive;
use AuthExpressive\Token\Token;
use Lcobucci\JWT\Token\Parser as Encoder;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Token\Parser;
use Lcobucci\JWT\Validator;
use Psr\Container\ContainerInterface;

class TokenFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new Token(
            $container->get(Builder::class),
            $container->get(Validator::class),
            $container->get(Sha256::class),
            $container->get(Key::class),
            $container->get(Parser::class),
            $container->get('config')[AuthExpressive::class]['attributeToJwt'],
            $container->get('config')[AuthExpressive::class]['middleware']
        );
    }
}
