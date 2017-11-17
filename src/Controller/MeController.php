<?php
namespace AuthExpressive\Controller;

use AuthExpressive\Interfaces\AuthProviderInterface;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class MeController implements MiddlewareInterface
{
    /**
     * @var AuthProviderInterface
     */
    private $authProvider;
    /**
     * @var string
     */
    private $attributeToRequest;

    public function __construct(AuthProviderInterface $authProvider, string $attributeToRequest)
    {
        $this->authProvider = $authProvider;
        $this->attributeToRequest = $attributeToRequest;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $identifier = $request->getAttribute($this->attributeToRequest);
        $data = $this->authProvider->getById($identifier, 'storage');
        return new JsonResponse(['success' => true, 'action' => 'me', 'data' => $data->toArray()]);
    }
}
