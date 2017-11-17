<?php
namespace AuthExpressive;

use AuthExpressive\Interfaces\AuthenticationInterface;
use AuthExpressive\Interfaces\AuthProviderInterface;
use AuthExpressive\Interfaces\UserInterface;
use Illuminate\Validation\Validator;

class Authentication implements AuthenticationInterface
{
    /**
     * @var AuthProviderInterface
     */
    protected $authProvider;


    /**
     * @param array $credentials
     * @param Validator $validator
     * @return bool|\Illuminate\Support\MessageBag|string
     */
    public function login(array $credentials, Validator $validator)
    {
        if ($validator->fails()) {
            return $validator->errors();
        }
        /** @var UserInterface $user */
        $user = $this->authProvider->getByCredentials($credentials);

        if (
            !$user ||
            false === $user->isLogged($credentials)
        ) {
            return false;
        }

        $this->authProvider->store($user);

        return $this->authProvider
            ->token()
            ->encode($user);
    }

    /**
     * @param array $credentials
     * @param Validator $validator
     * @return bool|\Illuminate\Support\MessageBag
     */
    public function register(array $credentials, Validator $validator)
    {
        if ($validator->fails()) {
            return $validator->errors();
        }

        $user = $this->authProvider->newUser($credentials);
        return $this->authProvider->save($user);
    }

    /**
     * @param array $credentials
     * @param Validator $validator
     * @return bool|\Illuminate\Support\MessageBag
     */
    public function update(array $credentials, Validator $validator)
    {
        if ($validator->fails()) {
            return $validator->errors();
        }

        $user = $this->authProvider->newUser($credentials);
        $this->authProvider->store($user);
        return $this->authProvider->save($user);
    }


    /**
     * @param $identifier
     * @return mixed
     */
    public function getFromStorage($identifier)
    {
        return $this->authProvider->getById($identifier, 'storage');
    }

    /**
     * @param UserInterface $user
     * @return bool
     */
    public function updateRememberToken(UserInterface $user)
    {
        $user->setRememberToken();
        return $this->authProvider->save($user);
    }

    /**
     * @param AuthProviderInterface $authProvider
     * @return $this
     */
    public function setProvider(AuthProviderInterface $authProvider)
    {
        $this->authProvider = $authProvider;
        return $this;
    }
}
