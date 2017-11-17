<?php
namespace AuthExpressive\Interfaces;

interface UserInterface
{
    /**
     * Return all attributes
     * @return mixed
     */
    public function getProperties();
    /**
     * Return identifier of user
     * @return mixed
     */
    public function getIdentifier();

    /**
     * @return string
     */
    public function getIdentifierName() : string;

    /**
     * @return mixed
     */
    public function getPassword();

    /**
     * @param $password
     * @return UserInterface
     */
    public function setPassword($password) : UserInterface;

    /**
     * Return remember_token of user
     * @return mixed
     */
    public function getRememberToken() : string;

    /**
     * @return mixed
     */
    public function setRememberToken();

    /**
     * Returns all abilities by user
     * @return mixed
     */
    public function getAbilities() : array;

    /**
     * Return is user active
     * @return mixed
     */
    public function isActive() : bool;

    /**
     * @param $credentials
     * @return bool
     */
    public function isLogged($credentials) : bool;

    /**
     * @param array $attributes
     * @return UserInterface
     */
    public function fill(array $attributes) : UserInterface;

    /**
     * @return string
     */
    public function toStorage() : string;

    /**
     * @param string $json
     * @return UserInterface
     */
    public function toModel(string $json) : UserInterface;

    public function toArray() : array;

}
