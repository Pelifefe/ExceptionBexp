<?php 

namespace App\Exceptions;

class CpfException extends BaseException
{
    protected function getErrorMessage()
    {
        return 'CPF erro';
    }
}
