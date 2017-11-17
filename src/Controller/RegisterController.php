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

class RegisterController implements MiddlewareInterface
{
    /**
     * @var AuthenticationInterface
     */
    private $authentication;
    /**
     * @var Factory
     */
    private $validatorFactory;

    public function __construct(AuthenticationInterface $authentication, Factory $validatorFactory)
    {
        $this->authentication = $authentication;
        $this->validatorFactory = $validatorFactory;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $credentials = $request->getParsedBody();
        $validator = $this->validatorFactory->make($credentials, [
            'name' => 'required|string|min:10',
            'username' => 'required|email',
            'password' => 'required|alpha_num|min:6',
        ]);

        if (false === $result = $this->authentication->register($credentials, $validator)) {
            return new NoSuccess(['error' => 'Error occur, please contact administrator to solve this!'], 'register');
        }

        if ($result instanceof MessageBag) {
            return new ValidationResponse($result, 'register');
        }

        return new SuccessResponse(['users' => 'created'], 201);
    }


}
