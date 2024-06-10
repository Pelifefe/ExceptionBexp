<?php

namespace App\Http\Controllers;

use App\Exceptions\AnotherCustomException;
use Illuminate\Http\Response;

class AnotherController extends Controller
{
    public function index($atribute = null)
    {
        try {
            if (is_null($atribute)) {
                throw new AnotherCustomException('campo_vazio');
            } else if (strpos($atribute, '0') !== false) {
                throw new AnotherCustomException('specific');
            }
            return response()->json(['message' => 'Teste realizado com sucesso', 'data' => $atribute], );
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
