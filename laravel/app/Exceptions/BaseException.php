<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

abstract class BaseException extends Exception
{
    protected $errorType;

    public function __construct($errorType = 'default', $code = 0, Exception $previous = null)
    {
        $this->errorType = $errorType;
        $message = $this->getErrorMessage($errorType);
        parent::__construct($message, $code, $previous);
    }
    abstract protected function getErrorMessage($errorType);
    public function render($request)
    {
        return response()->json([
            'error' => $this->errorType,
            'message' => $this->getMessage()
        ], Response::HTTP_BAD_REQUEST);
    }
}