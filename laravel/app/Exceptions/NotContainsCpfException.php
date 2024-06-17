<?php

namespace App\Exceptions;

use Illuminate\Support\Facades\Redirect;

class NotContainsCpfException extends CpfException
{
    protected function getErrorMessage()
    {
        return 'CPF não encontrado no sistema';
    }
    public function render($request)
    {
        return Redirect::route('cpf.cadastro')->with('error', $this->message);
    }

}