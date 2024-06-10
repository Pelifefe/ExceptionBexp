<?php

namespace App\Exceptions;

class AnotherCustomException extends BaseException
{
    protected function getErrorMessage($errorType)
    {
        switch ($errorType) {
            case 'specific':
                return 'Erro específico';
            case 'campo_vazio':
                return 'Campo vazio ou não informado';
            case 'default':
            default:
                return 'Erro desconhecido';
        }
    }
}
