<?php
namespace AuthExpressive\Model;

use AuthExpressive\Hash;
use AuthExpressive\Interfaces\UserInterface;
use Illuminate\Contracts\Support\Renderable;

class User implements UserInterface, \JsonSerializable
{
    protected $identifierAlias = '_id';
    protected $primaryKey = '_id';
    protected $abilities = [];
    protected $attributes = [];
    protected $properties = [
      'name', 'username', 'password', 'abilities', 'remember_token', 'active'
    ];

    protected $hidden = [
      'password', 'remember_token'
    ];

    public function __construct($attributes = [])
    {
        $this->initialize($attributes);
    }

    protected function username()
    {
        return 'username';
    }

    protected function password()
    {
        return 'password';
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @return mixed|null
     */
    public function getIdentifier()
    {
        return $this->getAttribute($this->identifierAlias);
    }

    /**
     * @return string
     */
    public function getIdentifierName(): string
    {
        return $this->identifierAlias;
    }


    /**
     * @return mixed|null
     */
    public function getPassword()
    {
        return $this->getAttribute('password') ?? null;
    }

    /**
     * @param $password
     * @return UserInterface
     */
    public function setPassword($password) : UserInterface
    {
        $this->setAttribute('password', $password);
        return $this;
    }

    /**
     * @return string
     */
    public function getRememberToken() : string
    {
        return $this->getAttribute('remember_token');
    }

    /**
     * @return $this
     */
    public function setRememberToken()
    {
        $this->setAttribute('remember_token', Hash::generateRememberToken());
        return $this;
    }

    /**
     * @return array
     */
    public function getAbilities() : array
    {
        return $this->getAttribute('abilities') ?? [];
    }

    /**
     * @return bool
     */
    public function isActive() : bool
    {
        return $this->getAttribute('active') ?? false;
    }

    /**
     * @param $credentials
     * @return bool
     */
    public function isLogged($credentials): bool
    {
        return $this->isActive() &&
            Hash::verify($credentials[$this->password()], $this->getPassword());
    }

    /**
     * Hash password if not have id or action is update
     */
    private function hashPassword()
    {
        if (!is_null($this->getIdentifier())) {
            return;
        }

        $this->setAttribute('password', Hash::password($this->getAttribute('password')));
    }

    /**
     * @param array $attributes
     * @return UserInterface
     */
    public function fill(array $attributes) : UserInterface
    {
        if (!$attributes) {
            return $this;
        }

        foreach ($this->properties as $property) {
            $this->fillAttributes($property, $attributes[$property] ?? null);
        }
        return $this;
    }

    /**
     * @return string
     */
    public function toStorage(): string
    {
        $attributes = $this->attributes;
        $attributes = array_diff_key($attributes, $this->hidden);
        return json_encode($attributes);
    }

    /**
     * @param string $json
     * @return UserInterface
     */
    public function toModel(string $json) : UserInterface
    {
        return (new self((array)json_decode($json)));
    }

    public function toArray(): array
    {
        return $this->attributes;
    }

    public function __toString()
    {
        return $this->toStorage();
    }


    /**
     * @param $key
     * @return mixed|null
     */
    private function getAttribute($key)
    {
        return $this->attributes[$key] ?? null;
    }

    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    private function setAttribute($key, $value)
    {
        return $this->attributes[$key] = $value;
    }

    /**
     * @param $key
     * @param $value
     * @param bool $withHidden
     */
    private function fillAttributes($key, $value, bool $withHidden = false)
    {
        if (
            in_array($key, $this->hidden) &&
            !$withHidden ||
            $value === null
        ) {
            return;
        }

        $this->setAttribute($key, $value);
    }

    /**
     * @param array $attributes
     */
    private function initialize($attributes)
    {
        if (!$attributes) {
            return;
        }

        if (is_string($attributes)) {
            $attributes = (array)json_decode($attributes);
        }

        foreach ($this->properties as $property) {
            $this->fillAttributes($property, $attributes[$property] ?? null, true);
        }

        $this->setIdentifier($attributes[$this->getIdentifierName()] ?? null);
        $this->hashPassword();
    }

    /**
     * Set identifier value
     * @param null $identifier
     */
    private function setIdentifier($identifier = null)
    {
        if (is_null($identifier)) {
            return;
        }
        $this->setAttribute($this->getIdentifierName(), $identifier);
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
