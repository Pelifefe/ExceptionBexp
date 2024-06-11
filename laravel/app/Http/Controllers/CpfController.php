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
        } catch (NullFieldCpfException $e) {
            return back()->withErrors($e->getMessage());
        } catch (IsNotValidCpfException $e) {
            return back()->withErrors($e->getMessage());
        } catch (NotContainsCpfException $e) {
            // Se não encontrar o CPF, redirecionar para a tela de cadastro de CPF
            return redirect()->route('cpf.cadastro')->withErrors($e->getMessage());
        }
    }

    //Função para verificar se o CPF está cadastrado
    // public function isContainsCpf(string $cpf): bool
    // {
    //     $lista = $this->dados();
    //     foreach ($lista as $user) {
    //         if ($user['cpf'] == $cpf) {
    //             return true;
    //         }
    //     }
    //     return false;
    // }

    private function isValid($cpf): bool
    {
        // Verifica se um número foi informado
        if (empty($cpf)) {
            throw new NullFieldCpfException();
        }

        // Verifica se nenhuma das sequências abaixo foi digitada, caso seja, retorna falso
        else if (
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
            // Calcula os digitos verificadores para verificar se o CPF é válido
        } else {
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
    }
    //Função para formatar o CPF
    private function formatCpf(string $cpf): string
    {
        // Elimina possivel mascara
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        // Verifica se o numero de digitos informados é igual a 11
        if (strlen($cpf) != 11) {
            return throw new IsNotValidCpfException();
        }
        return $cpf;
    }

    public function dados()
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
    function findCpf(array $data, string $cpf)
    {
        foreach ($data as $key => $item) {
            if ($item === $cpf) {
                return $item;  // CPF encontrado, retorna o próprio CPF
            }
        }
        return null;  // CPF não encontrado
    }

}
