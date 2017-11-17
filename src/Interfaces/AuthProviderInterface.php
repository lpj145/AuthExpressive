<?php
namespace AuthExpressive\Interfaces;

use AuthExpressive\Interfaces\TokenInterface;

interface AuthProviderInterface
{
    /**
     * @param $identifier
     * @param string $from
     * @return mixed
     */
    public function getById($identifier, string $from = 'database');
    /**
     * @param array $credentials
     * @return mixed
     */
    public function getByCredentials(array $credentials);

    /**
     * Return all users
     * @return array
     */
    public function getAll():array;

    /**
     * @param array $attributes
     * @return UserInterface
     */
    public function newUser($attributes = []) : UserInterface;
    /**
     * @param UserInterface $user
     * @return bool
     */
    public function save(UserInterface $user) : bool;
    /**
     * @param UserInterface $user
     * @return mixed
     */
    public function store(UserInterface $user) : void;
    /**
     * @param $identifier
     * @return mixed
     */
    public function unStore($identifier) : void;

    /**
     * @return TokenInterface
     */
    public function token() : TokenInterface;

    /**
     * @param int $timeSeconds
     * @return mixed
     */
    public function setTtl(int $timeSeconds) : void;
    /**
     * @param StorageInterface $storage
     * @return mixed
     */
    public function setStorage(StorageInterface $storage) : void;

    /**
     * @param string $prefix
     */
    public function setPrefixStorage(string $prefix) : void;
    /**
     * @param DatabaseInterface $database
     * @return mixed
     */
    public function setDatabase(DatabaseInterface $database) : void;
    /**
     * @param TokenInterface $token
     * @return mixed
     */
    public function setTokenDriver(TokenInterface $token) : void;
}
