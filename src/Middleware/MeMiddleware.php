<?php
namespace AuthExpressive\Middleware;

use AuthExpressive\Interfaces\AuthProviderInterface;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class MeMiddleware implements MiddlewareInterface
{
    /**
     * @var AuthProviderInterface
     */
    private $authProvider;
    /**
     * @var array
     */
    private $middlewareConfig;

    public function __construct(AuthProviderInterface $authProvider, array $middlewareConfig)
    {
        $this->authProvider = $authProvider;
        $this->middlewareConfig = $middlewareConfig;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $identifier = $request->getAttribute($this->middlewareConfig['attributeToRequest']);
        $user = $this->authProvider->getById($identifier, 'storage');
        $request = $request->withAttribute($this->middlewareConfig['attributeToMe'], $user);
        return $delegate->process($request);
    }
}
