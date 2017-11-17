<?php
namespace AuthExpressive\Token;

use AuthExpressive\Interfaces\TokenInterface;
use AuthExpressive\Interfaces\UserInterface;
use Lcobucci\Clock\SystemClock;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Lcobucci\JWT\Validation\Constraint\ValidAt;
use Lcobucci\JWT\Validator;

class Token implements TokenInterface
{
    /**
     * @var array
     */
    private $middlewareConfig;
    /**
     * @var Builder
     */
    private $builder;
    /**
     * @var Validator
     */
    private $validator;
    /**
     * @var Sha256
     */
    private $sha256;
    /**
     * @var Key
     */
    private $key;
    /**
     * @var string
     */
    private $attributeToJwt;
    /**
     * @var Parser
     */
    private $parser;

    public function __construct(
        Builder $builder,
        Validator $validator,
        Sha256 $sha256,
        Key $key,
        Parser $parser,
        string $attributeToJwt,
        array $middlewareConfig
    )
    {
        $this->builder = $builder;
        $this->validator = $validator;
        $this->sha256 = $sha256;
        $this->key = $key;
        $this->middlewareConfig = $middlewareConfig;
        $this->attributeToJwt = $attributeToJwt;
        $this->parser = $parser;
    }

    public function encode(UserInterface $user): string
    {
        $expireIn = (new SystemClock())
            ->now()
            ->add(new \DateInterval('PT'.$this->middlewareConfig['expireIn'].'S'));

        $token = $this->builder
            ->expiresAt($expireIn)
            ->withClaim($this->attributeToJwt, $user->getIdentifier())
            ->getToken($this->sha256, $this->key);

        return (string)$token;
    }

    public function decode(string $jwt)
    {
        try {
            return $this->parser->parse($jwt);
        }catch (\Throwable $exception) {
            return false;
        }
    }

    public function isValid(\Lcobucci\JWT\Token $token): bool
    {
        return
            $this->validator->validate(
                $token,
                new SignedWith($this->sha256, $this->key),
                new ValidAt(new SystemClock())
            );
    }

}
