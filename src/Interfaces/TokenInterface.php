<?php
namespace AuthExpressive\Interfaces;

use Lcobucci\JWT\Token;

interface TokenInterface
{
    public function encode(UserInterface $user) : string;
    public function decode(string $jwt);
    public function isValid(Token $token) : bool;
}
