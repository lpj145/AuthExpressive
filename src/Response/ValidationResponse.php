<?php
namespace AuthExpressive\Response;

use Illuminate\Contracts\Support\MessageBag;
use Zend\Diactoros\Response\JsonResponse;

class ValidationResponse extends JsonResponse
{
    public function __construct(MessageBag $bag, string $action)
    {
        parent::__construct([
            'success' => false,
            'action' => $action,
            'errors' => [
                'validation' => $bag->toArray()
            ],
            ],
            200,
            [],
            false
        );
    }
}
