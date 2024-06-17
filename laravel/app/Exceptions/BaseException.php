<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

abstract class BaseException extends Exception
{
    protected $errorMessage;

    public function __construct($message = null, $code = 0, Exception $previous = null)
    {
        $this->errorMessage = $message ?? $this->getErrorMessage();
        parent::__construct($this->errorMessage, $code, $previous);
    }

    abstract protected function getErrorMessage();

    public function render($request)
    {
        return response()->json([
            'message' => $this->getMessage()
        ], Response::HTTP_BAD_REQUEST);
    }
}
