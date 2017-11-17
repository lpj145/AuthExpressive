<?php
namespace AuthExpressive\Token\Factory;

use Interop\Container\ContainerInterface;
use Lcobucci\Jose\Parsing\Parser;

class EncoderFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new Parser();
    }
}
