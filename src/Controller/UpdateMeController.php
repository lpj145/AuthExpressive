<?php
namespace AuthExpressive\Controller;

use AuthExpressive\Interfaces\AuthenticationInterface;
use AuthExpressive\Response\NoSuccess;
use AuthExpressive\Response\SuccessResponse;
use AuthExpressive\Response\ValidationResponse;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\Factory;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UpdateMeController implements MiddlewareInterface
{
    /**
     * @var AuthenticationInterface
     */
    private $authentication;
    /**
     * @var Factory
     */
    private $factoryValidator;
    /**
     * @var
     */
    private $attributeToRequest;

    public function __construct(AuthenticationInterface $authentication, Factory $factoryValidator, $attributeToRequest)
    {
        $this->authentication = $authentication;
        $this->factoryValidator = $factoryValidator;
        $this->attributeToRequest = $attributeToRequest;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $credentials = $request->getParsedBody();
        $validator = $this->factoryValidator->make($credentials, [
            'name' => 'required|string|min:10',
            'username' => 'email',
            'password' => 'alpha_num|min:6',
        ]);
        $credentials['_id'] = $request->getAttribute($this->attributeToRequest);

        if (false === $result =$this->authentication->update($credentials, $validator)) {
            return new NoSuccess(['error' => 'Error occur, please contact administrator to solve this!'], 'update');
        }

        if ($result instanceof MessageBag) {
            return new ValidationResponse($result, 'update');
        }

        return new SuccessResponse(['users' => 'updated'], 204);
    }
}
