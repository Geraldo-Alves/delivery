<?php

namespace App\Http\Controllers\Cliente;

use App\Models\Pedido;
use App\Models\Produto;
use App\Models\Produtos_Pedido;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CarrinhoController extends Controller
{
    public function index(){
        //$user = Auth::user();
    }

    public function addProduto(Request $request)
    {
        $user = Auth::user();
        // Pedido
        $pedido = Pedido::where('id_usuario', $user->getAuthIdentifier())->where('status', 'C')->first();

        // Produto adicionado
        $produto = Produto::find($request->id_produto);

        // Para o caso do primeiro produto estar sendo adicionado
        if(empty($pedido)){
            // status C = Criado
            $novo_pedido = [
                'id_usuario' => $user->getAuthIdentifier(),
                'status' => 'C',
                'total' => $produto->valor,
                'qtd_produtos' => 1
            ];
            $pedido = Pedido::create($novo_pedido);

            if(!empty($pedido)){
                $produto_pedido = [
                    'id_pedido' => $pedido->id_pedido,
                    'id_produto' => $produto->id_produto,
                    'qtd' => 1
                ];
                $produtos_pedido = Produtos_Pedido::create($produto_pedido);

            }else{
                return response()->json(['result' => 'error', 'mensagem' => 'O Pedido não pôde ser salvo.'], 500);
            }
        }else{
            // Verifica se o produto já está presente no pedido, caso esteja, incrementa a quantidade
            $produto_presente = $pedido->produto($produto->id_produto);
            if(!empty($produto_presente)){
                // Atualiza o pedido
                $pedido->qtd_produtos += 1 ;
                $pedido->total+=$produto->valor;
                $pedido->save();

                // Atualiza a quantidade do produto na produtos_pedido @todo verificar outra forma de fazer essa atualização
                DB::table( 'produtos_pedido')
                    ->where('id_pedido', $pedido->id_pedido)
                    ->where('id_produto', $produto->id_produto)
                    ->increment('qtd', 1);
            }

            // Caso não esteja, adiciona o novo produto
            else{
                $produto_pedido = [
                    'id_pedido' => $pedido->id_pedido,
                    'id_produto' => $produto->id_produto,
                    'qtd' => 1
                ];

                $pedido->qtd_produtos++;
                $pedido->total+=$produto->valor;
                $pedido->save();

                $produtos_pedido = Produtos_Pedido::create($produto_pedido);
            }
        }

        // Atribui a quantidade pra cada produto adicionado
        for($i=0;$i<sizeof($pedido->produtos);$i++){
            $inc = $pedido->produto_pedido($pedido->produtos[$i]->id_produto);
            $pedido->produtos[$i]->qtd = $inc->qtd;
        }

        $pedido->produtos;

        return response()->json(['result' => 'success', 'pedido' => $pedido], 200);
    }

    public function removeProduto(Request $request)
    {
        $user = Auth::user();
        // Pedido
        $pedido = Pedido::where('id_usuario', $user->getAuthIdentifier())->where('status', 'C')->first();

        // Atualiza o valor do pedido
        $pedido->total-=$pedido->produto($request->id_produto)->valor;

        if(!empty($pedido)){
            $dec = $pedido->produto_pedido($request->id_produto);
            // Caso haja mais de um desse produto no pedido
            if($dec->qtd>1){
                // Atualiza o registro, decrementando a qtd
                // Atualiza a quantidade do produto na produtos_pedido @todo verificar outra forma de fazer essa atualização
                DB::table( 'produtos_pedido')
                    ->where('id_pedido', $pedido->id_pedido)
                    ->where('id_produto', $request->id_produto)
                    ->decrement('qtd', 1);

            }else{
                // Deleta o registro do produto no pedido
                DB::table('produtos_pedido')
                    ->where('id_produto', $request->id_produto)
                    ->where('id_pedido', $pedido->id_pedido)
                    ->delete();

            }

            // Atualiza o pedido
            $pedido->qtd_produtos -= 1 ;
            $pedido->save();

            for($i=0;$i<sizeof($pedido->produtos);$i++){
                $inc = $pedido->produto_pedido($pedido->produtos[$i]->id_produto);
                $pedido->produtos[$i]->qtd = $inc->qtd;
            }

            return response()->json(['result' => 'success', 'pedido' => $pedido], 200);
        }else{
            return response()->json(['result' => 'error', 'mensagem' => 'Pedido inválido'], 500);
        }
    }

    public function carrinho(Request $request){
        $user = Auth::user();
        // Pedido
        $pedido = Pedido::where('id_usuario', $user->getAuthIdentifier())->where('status', 'C')->first();
        if(!empty($pedido)){
            // Atribui a quantidade pra cada produto adicionado
            for($i=0;$i<sizeof($pedido->produtos);$i++){
                $inc = $pedido->produto_pedido($pedido->produtos[$i]->id_produto);
                $pedido->produtos[$i]->qtd = $inc->qtd;
            }
            return response()->json(['result' => 'success', 'pedido' => $pedido], 200);
        }
    }
}
