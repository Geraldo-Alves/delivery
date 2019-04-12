<?php

namespace App\Http\Controllers\Api;

use App\Models\Categoria;
use App\Models\Empresa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProdutosController extends Controller
{
    public function produtosEmpresa($id_empresa=null){
        $empresa = Empresa::find($id_empresa);

        if(!empty($empresa)){
            $categorias = $empresa->categorias;
            foreach ($categorias as $categoria){
                $categoria->produtos;
            }
            return response()->json(['result' => 'success', 'categorias' => $categorias],200);
        }else{
            return response()->json(['result' => 'error', 'mensagem' => 'Empresa inválida'],200);
        }
    }
}
