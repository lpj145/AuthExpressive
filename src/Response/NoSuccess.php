<?php
namespace AuthExpressive\Response;

use Zend\Diactoros\Response\JsonResponse;

class NoSuccess extends JsonResponse
{
    public function __construct($data = null, string $action)
    {
        parent::__construct([
                'success' => false,
                'action' => $action,
                'data' => $data
            ],
            200,
            [],
            false
        );
    }
}
