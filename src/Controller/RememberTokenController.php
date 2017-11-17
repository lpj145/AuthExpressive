<?php
namespace AuthExpressive\Controller;

use AuthExpressive\Interfaces\AuthenticationInterface;
use AuthExpressive\Response\SuccessResponse;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class RememberTokenController implements MiddlewareInterface
{
    /**
     * @var AuthenticationInterface
     */
    private $authentication;
    /**
     * @var string
     */
    private $attributeToRequest;

    public function __construct(AuthenticationInterface $authentication, string $attributeToRequest)
    {
        $this->authentication = $authentication;
        $this->attributeToRequest = $attributeToRequest;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $identifier = $request->getAttribute($this->attributeToRequest);
        $user = $this->authentication->getFromStorage($identifier);
        $this->authentication->updateRememberToken($user);

        return new SuccessResponse(['users' => 'remember token redefined!'], 204);
    }
}
