<?php
namespace AuthExpressive\Response;

use Zend\Diactoros\Response\JsonResponse;

class LoginSuccess extends JsonResponse
{
    public function __construct(string $token, int $expireIn)
    {
        parent::__construct(['success' => true, 'access_token' => $token, 'expireIn' => $expireIn], 200, [], false);
    }
}
