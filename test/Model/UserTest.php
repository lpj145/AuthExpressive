<?php
namespace Model;

use AuthExpressive\Interfaces\UserInterface;
use AuthExpressive\Model\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testInterface()
    {
        $user = self::newUserWithData();
        self::assertTrue($user instanceof UserInterface);
    }

    public function testisLoggedMethod()
    {
        $user = self::newUserWithData();
        $credentials = ['username' => 'marcos', 'password' => 'abc'];
        self::assertTrue($user->isLogged($credentials));
    }

    public function testConstructWithJson()
    {
        $credentials = ['username' => 'marcos', 'password' => 'abc'];
        $user = new User('{"name":"Marcos Dantas","username":"yptest","password":"$2a$04$cnIN6bQegDZU\/uajW2laruMyJ9zH.W6lZ1az1iteZz.EHlhSK800C","active":true}');
        self::assertTrue($user->isLogged($credentials));
    }

    public function testFillMethod()
    {
        $data = ['username' => 'yptest'];
        $user = new User();
        self::assertTrue($user->fill($data) instanceof UserInterface);
    }

    public function testToCacheMethod()
    {
        $user = self::newUserWithData();
        self::assertTrue(is_string($user->toStorage()));
    }

    public function testToModelMethod()
    {
        $user = self::newUserWithData();
        $json = $user->toStorage();
        self::assertTrue($user->toModel($json) instanceof UserInterface);
    }

    public static function newUserWithData()
    {
        return new User([
            '_id' => '78yhqwe89huwen',
            'name' => 'marcos dantas',
            'active' => true,
            'username' => 'yptest',
            'password' => '$2a$04$cnIN6bQegDZU/uajW2laruMyJ9zH.W6lZ1az1iteZz.EHlhSK800C'
        ]);
    }
}

