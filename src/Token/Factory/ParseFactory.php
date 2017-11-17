<?php
namespace AuthExpressive\Token\Factory;

use Lcobucci\JWT\Token\Parser;
use Psr\Container\ContainerInterface;
use Lcobucci\Jose\Parsing\Parser as EncoderDecoder;

class ParseFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new Parser($container->get(EncoderDecoder::class));
    }
}
