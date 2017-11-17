<?php
namespace AuthExpressive\Controller;

use AuthExpressive\Interfaces\AuthenticationInterface;
use AuthExpressive\Response\LoginSuccess;
use AuthExpressive\Response\NoSuccess;
use AuthExpressive\Response\ValidationResponse;
use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Validation\Factory;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Zend\Diactoros\Response\EmptyResponse;

class LoginController implements MiddlewareInterface
{
    /**
     * @var AuthenticationInterface
     */
    private $authentication;
    /**
     * @var Factory
     */
    private $validatorFactory;
    /**
     * @var int
     */
    private $expireIn;

    public function __construct(AuthenticationInterface $authentication, Factory $validatorFactory, int $expireIn)
    {
        $this->authentication = $authentication;
        $this->validatorFactory = $validatorFactory;
        $this->expireIn = $expireIn;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $credentials = $request->getParsedBody();
        $validator = $this->validatorFactory->make($credentials, [
            'username' => 'required|email',
            'password' => 'required|alpha_num|min:6|max:12'
        ]);

        if (false === $result = $this->authentication->login($credentials, $validator)) {
            return new NoSuccess(['errors' => 'Login credentials incorrect!'], 'login');
        }

        if ($result instanceof MessageBag) {
            /** @var MessageBag $result */
            return new ValidationResponse($result, 'login');
        }
        return new LoginSuccess($result, $this->expireIn);
    }

}
