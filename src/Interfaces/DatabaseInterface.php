<?php
namespace AuthExpressive\Interfaces;

use AuthExpressive\Model\User;

interface DatabaseInterface
{
    public function retrieveById($identifier) : array;

    public function retrieveByCredentials(array $credentials) : array;

    public function retrieveList() : array;

    /**
     * @param array|User|static $attributes
     * @return bool
     */
    public function persist($attributes) : bool;
}
