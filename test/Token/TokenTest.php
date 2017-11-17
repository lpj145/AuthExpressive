<?php
namespace Token;

use AuthExpressive\Interfaces\TokenInterface;
use AuthExpressive\Model\User;
use AuthExpressive\Token\Token;
use Lcobucci\Jose\Parsing\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Token\Builder;
use Lcobucci\JWT\Validation\Validator;
use Model\UserTest;
use PHPUnit\Framework\TestCase;

class TokenTest extends TestCase
{
    public function testInterfaceImplementation()
    {
        $token = self::getToken();
        self::assertTrue($token instanceof TokenInterface);
    }

    public function testEncode()
    {
        $token = self::getToken();
        $user = UserTest::newUserWithData();
        print_r($token->encode($user));
        self::assertTrue(is_string($token->encode($user)));
    }

    public function testDecode()
    {
        $jwt = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOiIxNTA4MjA3NjgwLjIwODAxMyIsInV1aWQiOiI3OHlocXdlODlodXdlbiJ9.FMHgm5Y_qs5leR33p-qzUwPfqZ4WJAePYLUiF9I3BCU';
        $token = (self::getToken())->decode($jwt);
        self::assertTrue($token instanceof \Lcobucci\JWT\Token);
    }

    public static function getToken()
    {
        $encDec  = new Parser();
        $builder = new Builder($encDec);
        $parser = new \Lcobucci\JWT\Token\Parser($encDec);
        $validator = new Validator();
        $sha256 = new Sha256();
        $key = new Key('e78hwq21e821ped918f21f8r67fiyk67r8iftkvi67tgfyk1d12ds12d1');
        $attributeToJwt = 'uuid';
        $middlewareConfig = [
          'expireIn' => 3600,
          'passRoutes' => [],
          'attributeToRequest' => 'auth'
        ];
        return new Token($builder, $validator, $sha256, $key, $parser, $attributeToJwt, $middlewareConfig);
    }
}
