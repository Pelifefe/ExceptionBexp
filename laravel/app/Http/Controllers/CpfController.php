<?php

namespace App\Http\Controllers;

use App\Exceptions\CpfException;
use App\Exceptions\IsNotValidCpfException;
use App\Exceptions\NotContainsCpfException;
use App\Exceptions\NullFieldCpfException;
use Illuminate\Http\Request;

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
            // Se não enviar nada, retornar com erro
            if (is_null($cpf)) {
                throw new NullFieldCpfException();
            }

            // Limpar os caracteres especiais
            $cpf = $this->formatCpf($cpf);

            // Validar o cálculo de CPF
            if (!$this->isValid($cpf)) {
                throw new IsNotValidCpfException();
            }

            // Buscar se o CPF já está cadastrado
            $resultado = $this->findCpf($this->dados(), $cpf);

            // Se não encontrar o CPF na lista, redirecionar para a tela de cadastro de CPF
            if (is_null($resultado)) {
                throw new NotContainsCpfException();
            }

            // Informar que CPF foi encontrado e já está cadastrado
            return response()->json($resultado);
        } catch (CpfException $e) {
            return $e->render(request());
        }
    }

    private function isValid($cpf): bool
    {
        // Verifica se um número foi informado
        if (empty($cpf)) {
            throw new NullFieldCpfException();
        }

        // Verifica se nenhuma das sequências abaixo foi digitada, caso seja, retorna falso
        if (
            $cpf == '00000000000' ||
            $cpf == '11111111111' ||
            $cpf == '22222222222' ||
            $cpf == '33333333333' ||
            $cpf == '44444444444' ||
            $cpf == '55555555555' ||
            $cpf == '66666666666' ||
            $cpf == '77777777777' ||
            $cpf == '88888888888' ||
            $cpf == '99999999999'
        ) {
            return false;
        }

        // Calcula os digitos verificadores para verificar se o CPF é válido
        for ($i = 9; $i < 11; $i++) {
            for ($x = 0, $y = 0; $y < $i; $y++) {
                $x += $cpf[$y] * (($i + 1) - $y);
            }
            $x = ((10 * $x) % 11) % 10;
            if ($cpf[$y] != $x) {
                return false;
            }
        }
        return true;
    }

    private function formatCpf(string $cpf): string
    {
        
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        if (strlen($cpf) != 11) {
            throw new IsNotValidCpfException();
        }

        if (!ctype_digit($cpf)) {
            throw new IsNotValidCpfException();
        }

        return $cpf;
    }
    public function dados(): array
    {
        // Lista de usuários cadastrados
        return [
            '48148839867',
            '76136366070',
            '43765105058',
            '52583225804',
            '56048450001',
        ];
    }

    private function findCpf(array $data, string $cpf): ?string
    {
        foreach ($data as $item) {
            if ($item === $cpf) {
                return $item;  // CPF encontrado, retorna o próprio CPF
            }
        }
        return null;  // CPF não encontrado
    }
}
