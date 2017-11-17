<?php
namespace AuthExpressive;

use AuthExpressive\Interfaces\AuthProviderInterface;
use AuthExpressive\Interfaces\DatabaseInterface;
use AuthExpressive\Interfaces\StorageInterface;
use AuthExpressive\Interfaces\TokenInterface;
use AuthExpressive\Interfaces\UserInterface;
use AuthExpressive\Model\User;

class AuthProvider implements AuthProviderInterface
{
    /**
     * @var TokenInterface
     */
    protected $tokenDriver;
    /**
     * @var DatabaseInterface
     */
    protected $database;
    /**
     * @var StorageInterface
     */
    protected $storage;

    /**
     * Time to expire
     * @var int
     */
    protected $ttl;

    /**
     * @var string
     */
    protected $authPrefixStorage = 'auth:';


    public function getById($identifier, string $from = 'database')
    {
        $data = [];
        if ($from === 'storage') {
            $data = $this->storage->get($this->authPrefixStorage.$identifier);
        }

        if ($from === 'database') {
            $data = $this->database->retrieveById($identifier);
        }

        return $this->newUser($data);
    }

    public function getByCredentials(array $credentials)
    {
        $data = $this->database->retrieveByCredentials($credentials);
        return $this->newUser($data);
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        $listOfUsers = [];
        $users = $this->database->retrieveList();
        foreach ($users as $user) {
            $listOfUsers[] = $this->newUser($user);
        }
        return $listOfUsers;
    }

    public function newUser($attributes = []): UserInterface
    {
        return new User($attributes);
    }

    public function save(UserInterface $user): bool
    {
        return $this->database->persist($user);
    }

    public function store(UserInterface $user) : void
    {
        $this->storage->set($this->authPrefixStorage.$user->getIdentifier(), $user, $this->ttl);
    }

    public function token(): TokenInterface
    {
        return $this->tokenDriver;
    }

    /**
     * @param $identifier
     */
    public function unStore($identifier) : void
    {
        $this->storage->delete($this->authPrefixStorage.$identifier);
    }

    /**
     * @param int $timeSeconds
     */
    public function setTtl(int $timeSeconds) : void
    {
        $this->ttl = $timeSeconds;
    }

    /**
     * @param StorageInterface $storage
     */
    public function setStorage(StorageInterface $storage) : void
    {
        $this->storage = $storage;
    }

    /**
     * @param string $prefix
     */
    public function setPrefixStorage(string $prefix): void
    {
        $this->authPrefixStorage = $prefix;
    }


    /**
     * @param DatabaseInterface $database
     */
    public function setDatabase(DatabaseInterface $database) : void
    {
        $this->database = $database;
    }

    /**
     * @param TokenInterface $token
     */
    public function setTokenDriver(TokenInterface $token) : void
    {
        $this->tokenDriver = $token;
    }
}
