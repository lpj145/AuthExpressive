<?php
namespace AuthExpressive\Token\Factory;

use Lcobucci\Jose\Parsing\Parser;
use Psr\Container\ContainerInterface;

class DecoderFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new Parser();
    }
}
