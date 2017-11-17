<?php
namespace AuthExpressive\Middleware;

use AuthExpressive\Interfaces\TokenInterface;
use AuthExpressive\Response\Unauthorized;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Lcobucci\JWT\Token\Plain;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class JwtMiddleware implements MiddlewareInterface
{
    /**
     * @var TokenInterface
     */
    private $token;
    /**
     * @var array
     */
    private $middlewareConfig;
    /**
     * @var string
     */
    private $attributeToJwt;

    public function __construct(TokenInterface $token, string $attributeToJwt,array $middlewareConfig)
    {
        $this->token = $token;
        $this->middlewareConfig = $middlewareConfig;
        $this->attributeToJwt = $attributeToJwt;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        if (in_array($request->getRequestTarget(), $this->middlewareConfig['passRoutes'])) {
            return $delegate->process($request);
        }

        if (
            $this->middlewareConfig['secure'] &&
            $request->getUri()->getScheme() !== 'https' ||
            !$request->hasHeader('Authorization')
        ) {
            return new Unauthorized();
        }

        $jwt = $this->getTokenWithoutBearer($request->getHeaderLine('Authorization'));
        $token = $this->token->decode($jwt);
        if (
            false === $token ||
            !$this->token->isValid($token)
        ) {
            return new Unauthorized();
        }

        /** @var Plain $token */
        $token = $this->token->decode($jwt);
        $userId = $token->claims()->get($this->attributeToJwt);
        $request = $request->withAttribute(
            $this->middlewareConfig['attributeToRequest'], $userId
        );

        return $delegate->process($request);
    }

    /**
     * @param string $headerValue
     * @return mixed
     */
    private function getTokenWithoutBearer(string $headerValue)
    {
        return str_replace('Bearer ', '', $headerValue);
    }
}
