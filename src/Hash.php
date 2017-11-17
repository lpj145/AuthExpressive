<?php
namespace AuthExpressive;

class Hash
{
    const PASSWORD_TYPE = PASSWORD_DEFAULT;

    /**
     * @param $password
     * @return bool|string
     */
    public static function password($password)
    {
        return password_hash($password, self::PASSWORD_TYPE);
    }

    /**
     * @param $password
     * @param $hash
     * @return bool
     */
    public static function verify($password, $hash)
    {
        return password_verify($password, $hash);
    }

    /**
     * @param int $len
     * @return bool|string
     */
    public static function generateRememberToken(int $len = 32)
    {
        return substr(md5(openssl_random_pseudo_bytes(20)),-$len);
    }

}
