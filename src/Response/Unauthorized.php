<?php
namespace AuthExpressive\Response;

use AuthExpressive\AuthExpressive;
use Zend\Diactoros\Response\TextResponse;

class Unauthorized extends TextResponse
{
    public function __construct()
    {
        parent::__construct('You are not allowed to access this resource', AuthExpressive::UNAUTHORIZED_CODE, []);
    }
}