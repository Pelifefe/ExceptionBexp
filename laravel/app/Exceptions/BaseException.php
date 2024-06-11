<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

abstract class BaseException extends Exception
{
    public function __construct($message = 'default error', $code = 0, Exception $previous = null)
    {   
        parent::__construct($message, $code, $previous);
    }

    abstract protected function getErrorMessage();

    public function render($request)
    {
        return response()->json([
            'message' => $this->getMessage()
        ], Response::HTTP_BAD_REQUEST);
    }
}
