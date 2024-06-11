<?php

namespace App\Exceptions;

class NullFieldCpfException extends CpfException
{
    protected function getErrorMessage()
    {
        return 'Campo CPF nulo ou não informado';
    }
}