<?php

namespace App\Exceptions;

final class AnotherCustomException extends BaseException
{
    protected function getErrorMessage()
    {
        return 'Erro desconhecido';    
    }
    
}
