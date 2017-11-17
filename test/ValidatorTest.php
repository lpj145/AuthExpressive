<?php

use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    public function testValidator()
    {
        $data = $this->getData();
        $loader = new \Illuminate\Translation\FileLoader(new \Illuminate\Filesystem\Filesystem(), __DIR__.'/../locale/');
        $translator = new \Illuminate\Translation\Translator($loader, 'pt-br');
        $validator = (new \Illuminate\Validation\Factory($translator))->make($data, [
            'username' => 'required|email'
        ]);

        self::assertFalse($validator->fails());
    }

    public function getData()
    {
        return [
          'username' => 'marcos.adantas@hotmail.com',
          'password' => 'abc'
        ];
    }
}