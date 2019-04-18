<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pedido;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PedidoController extends Controller
{
    public function index(){
        return view('admin.pedidos');
    }

    public function pedidosAt($at){

        $pedidos = Pedido::orderByDesc('updated_at')->get();
        foreach ($pedidos as $pedido){
            $pedido->produtos;
            $pedido->cliente;
        }
        return response()->json(['result' => 'success', 'pedidos' => $pedidos], 200);
    }

    public function pedidosByStatus($status){
        $pedidos = Pedido::where('status', '=', $status)->orderByDesc('updated_at')->get();
        foreach ($pedidos as $pedido){
            $pedido->produtos;
            $pedido->cliente;
        }
        return response()->json(['result' => 'success', 'pedidos' => $pedidos], 200);
    }

    public function proximoStatus($idPedido){
        $pedido = Pedido::find($idPedido);

        $status = $pedido->status;
        $novo_status = '';
        /**
         * Aplicação da lógica de alteração do status
         */

        if($status=='criado'){
            $novo_status = 'em_producao';
        }else if($status=='em_producao'){
            $novo_status = 'pronto';
        }else if($status=='pronto'){
            $novo_status = 'entrega';
        }else if($status=='entrega'){
            $novo_status = 'concluido';
        }else if($status=='concluido'){
            $novo_status='concluido';
        }

        $pedido->status = $novo_status;
        $pedido->save();

        return response()->json(['result' => 'success', 'pedido' => $pedido], 200);

    }

    public function statusAnterior($idPedido){
        $pedido = Pedido::find($idPedido);

        $status = $pedido->status;
        $novo_status = '';
        /**
         * Aplicação da lógica de alteração do status
         */

        if($status=='criado'){
            $novo_status = 'criado';
        }else if($status=='em_producao'){
            $novo_status = 'criado';
        }else if($status=='pronto'){
            $novo_status = 'em_producao';
        }else if($status=='entrega'){
            $novo_status = 'pronto';
        }else if($status=='concluido'){
            $novo_status='entrega';
        }

        $pedido->status = $novo_status;
        $pedido->save();

        return response()->json(['result' => 'success', 'pedido' => $pedido], 200);

    }
}
