<?php

namespace App\Exceptions;

use Illuminate\Support\Facades\Redirect;

class NotContainsCpfException extends BaseException
{
    protected function getErrorMessage()
    {
        return 'CPF não encontrado';
    }
    public function render($request){
        //Verifica se o Cpf na base de dados e redereciona para a tela de cadastro de CPF
        return Redirect::route('cpf.cadastro');
    }
}