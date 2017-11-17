<?php
namespace AuthExpressive\Response;

use Zend\Diactoros\Response\JsonResponse;

class SuccessResponse extends JsonResponse
{
    public function __construct($data = null, $code = 200)
    {
        parent::__construct(['success' => true, 'data' => $data], $code, [], false);
    }
}
