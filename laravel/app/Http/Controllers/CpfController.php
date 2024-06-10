<?php

namespace App\Http\Controllers;

use App\Exceptions\UndefinedCpfException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CpfController extends Controller
{
    public function buscar(Request $request)
    {
        $cpf = $request->input('cpf');  
        return $this->index($cpf);
    }
    public function index($cpf = null)
    {
        try {
            if (is_null($cpf)) {
                throw new UndefinedCpfException('undefined');
            }
            $cpf = $this->formatCpf($cpf);
            if (!$this->isContainsCpf($cpf)) {
                throw new UndefinedCpfException('!contains');
            }
            $dados = $this->dados($cpf);
            return response()->json(['message' => 'Usuário encontrado no sistema', 'data' => $dados], Response::HTTP_CREATED);

        } catch (UndefinedCpfException $e) {
            return $e->getMessage(); //Exibe erro original
        }
    }

    //Função para verificar se o CPF está cadastrado
    public function isContainsCpf(string $cpf): bool
    {
        $lista = $this->dados();
        foreach ($lista as $user) {
            if ($user['cpf'] == $cpf) {
                return true;
            }
        }
        return false;
    }

    public function dados($cpf = null)
    {
        // Lista de usuários cadastrados
        $lista = [
            1 => [
                'nome' => 'Leonardo Sartori',
                'cpf' => '481.488.398-67',
                'data_nascimento' => '04/08/1998',
                'empresa' => 38,
                'email' => 'leonardo.sartori@bexp.com.br',
            ],
            2 => [
                'nome' => 'Fulano de Duo Jaguaré',
                'cpf' => '123.456.789-10',
                'data_nascimento' => '01/01/1990',
                'empresa' => 46,
                'email' => 'suporte@bexp.com.br',
            ],
            3 => [
                'nome' => 'Deutrano de Alphaville',
                'cpf' => '223.426.339-13',
                'data_nascimento' => '02/12/2003',
                'empresa' => 36,
                'email' => 'deutrano.alphaville@audicenteralphaville.com.br',
            ],
            4 => [
                'nome' => 'Felippe Pedrosa',
                'cpf' => '525.832.258-04',
                'data_nascimento' => '21/03/2004',
                'empresa' => 44,
                'email' => 'felippe.pedrosa@bexp.com.br',
            ]
        ];
        // Retorna a lista completa
        if ($cpf == null) {
            return $lista;
        } else {
            foreach ($lista as $user) {
                if ($user['cpf'] == $cpf) {
                    return $user;
                }
            }
        }
        return null;
    }

    //Função para formatar o CPF
    private function formatCpf(string $cpf): string
    {
        // Remove caracteres não numéricos
        $cpf = preg_replace('/\D/', '', $cpf);
        // Verifica se o CPF possui 11 caracteres
        if (strlen($cpf) != 11) {
            throw new UndefinedCpfException('invalid');
        }
        // Formata o CPF ###.###.###-##
        return substr_replace(substr_replace(substr_replace($cpf, '.', 3, 0), '.', 7, 0), '-', 11, 0);
    }
}
