<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class GeneralJsonException extends Exception
{
    protected $code=422;
    public function  report(){

    }
    public function  render($request): JsonResponse
    {
        return new JsonResponse([
            'errors'=>[
                'messages'=> $this->getMessage()
            ]

        ], $this->code);
    }
}
