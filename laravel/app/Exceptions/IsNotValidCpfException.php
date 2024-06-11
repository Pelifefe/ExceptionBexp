<?php 

namespace App\Exceptions;

class IsNotValidCpfException extends CpfException
{
    protected function getErrorMessage()
    {
        return 'CPF inválido';
    }
}