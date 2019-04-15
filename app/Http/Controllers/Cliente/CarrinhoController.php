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

    public function addProduto(Request $request){
        $produto = Produto::find($request->id_produto);
        $carrinho = [];

        if($request->session()->has('carrinho')){
            dd('here');
            $carrinho = $request->session('carrinho');
        }
        array_push($carrinho, $produto);
        // Sessão
        $request->session()->put('carrinho', $carrinho);

        dd($carrinho);
    }
}
