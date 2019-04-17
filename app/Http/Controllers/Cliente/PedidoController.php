<?php

namespace App\Http\Controllers\Cliente;

use App\Models\Pedido;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    public function index(Request $request){
        $user = Auth::user();

        // Pedido
        $pedido = Pedido::where('id_usuario', $user->getAuthIdentifier())->where('status', 'C')->first();

        return view('cliente.pedido');
    }
}
