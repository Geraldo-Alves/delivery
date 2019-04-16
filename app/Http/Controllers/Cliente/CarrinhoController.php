<?php

namespace App\Http\Controllers\Cliente;

use App\Models\Produto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CarrinhoController extends Controller
{
    public function index(){
        $user = Auth::user();
    }

    public function addProduto(Request $request)
    {
        $produto = Produto::find($request->id_produto);

        $addNew = true;
        if($request->session()->has('carrinho')){
            $carrinho = $request->session()->get('carrinho');
            $request->session()->forget('carrinho');

            $total = 0;
            for ($i=0; $i<sizeof($carrinho['produtos']);$i++){
                $a_produto = $carrinho['produtos'][$i];

                // Verifica se existe o produto que está sendo selecionado
                if($a_produto->id_produto == $request->id_produto){
                    $a_produto->qtd += 1;
                    $addNew = false;
                    //$request->session()->push('carrinho.produtos', $a_produto);
                }

                $request->session()->push('carrinho.produtos', $a_produto);

                $total += $a_produto->valor;
            }

            if($addNew){
                $produto->qtd = 1;
                $total += $produto->valor;
                $request->session()->push('carrinho.produtos', $produto);
            }
        }else{
            $produto->qtd = 1;
            $request->session()->push('carrinho.produtos', $produto);
        }

        $carrinho = $request->session()->get('carrinho');
        return response()->json(['total' => $total, 'produtos' => $carrinho['produtos']], 200);
    }

    public function removeProduto(Request $request)
    {
        $carrinho = $request->session()->get('carrinho');

        $n_carrinho = [
            'produtos' => []
        ];

        $total = 0;
        for ($i=0; $i<sizeof($carrinho['produtos']); $i++){
            $produto = $carrinho['produtos'][$i];
            if($produto->id_produto != $request->id_produto){
                array_push($n_carrinho['produtos'], $carrinho['produtos'][$i]);
            }
        }

        $request->session()->forget('carrinho');
        $request->session()->put('carrinho', $n_carrinho);

        $carrinho = $request->session()->get('carrinho');
        return response()->json(['total' => $total, 'produtos' => $carrinho['produtos']], 200);
    }

    public function carrinho(Request $request){
        if($request->session()->has('carrinho')){
            $carrinho = $request->session()->get('carrinho');
            $total = 0;
            foreach ($carrinho['produtos'] as $produto){
                $total += $produto->valor;
            }
            return response()->json(['total' => $total, 'produtos' => $carrinho['produtos']], 200);
        }else{
            return response()->json(['total' => 0, 'produtos' => 0], 200);
        }
    }
}
