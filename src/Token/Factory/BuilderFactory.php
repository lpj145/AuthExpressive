<?php
namespace AuthExpressive\Token\Factory;

use Lcobucci\Jose\Parsing\Parser as EncoderDecoder;
use Lcobucci\JWT\Token\Builder;
use Psr\Container\ContainerInterface;

class BuilderFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new Builder($container->get(EncoderDecoder::class));
    }
}
