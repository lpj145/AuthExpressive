<?php
use AuthExpressive\Authentication;
use PHPUnit\Framework\TestCase;

class AuthenticationTest extends TestCase
{
    public function testInterface()
    {
        $auth = new Authentication();
        self::assertTrue($auth instanceof \AuthExpressive\Interfaces\AuthenticationInterface);
    }
}
