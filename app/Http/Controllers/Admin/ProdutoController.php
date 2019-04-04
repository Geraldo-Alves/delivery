<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProdutoController extends Controller
{
    public function index(Request $request){
        $user = Auth::user();
        $empresa = $user->empresa;
        $categorias = $empresa->categorias;
        return view('admin.categoria_produtos')->with(['categorias' => $categorias]);
    }
}
