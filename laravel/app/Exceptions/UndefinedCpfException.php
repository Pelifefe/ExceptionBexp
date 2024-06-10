<?php

namespace App\Exceptions;

class UndefinedCpfException extends BaseException
{
    protected function getErrorMessage($errorType)
    {
        switch ($errorType) {
            case 'undefined':
                return 'CPF indefinido, campo vazio ou não informado';
            case 'invalid':
                return 'CPF inválido, quantidade de caracteres insuficiente';
            case '!contains':
                return 'CPF não encontrado no sistema';
            case 'default':
            default:
                return 'Erro desconhecido com CPF'; 
        }
    }
}