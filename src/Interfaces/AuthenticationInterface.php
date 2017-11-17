<?php
namespace AuthExpressive\Interfaces;

use Illuminate\Validation\Validator;

interface AuthenticationInterface
{
    /**
     * @param array $credentials
     * @param Validator $validator
     * @return mixed
     */
    public function login(array $credentials, Validator $validator);
    /**
     * @param array $credentials
     * @param Validator $validator
     * @return mixed
     */
    public function register(array $credentials, Validator $validator);
    /**
     * @param array $credentials
     * @param Validator $validator
     * @return mixed
     */
    public function update(array $credentials, Validator $validator);
    /**
     * @param $identifier
     * @return mixed
     */
    public function logout($identifier) : void;
    /**
     * @param $identifier
     * @return mixed
     */
    public function getFromStorage($identifier);
    /**
     * @param UserInterface $user
     * @return mixed
     */
    public function updateRememberToken(UserInterface $user);
    /**
     * @param AuthProviderInterface $authProvider
     * @return mixed
     */
    public function setProvider(AuthProviderInterface $authProvider);
}
