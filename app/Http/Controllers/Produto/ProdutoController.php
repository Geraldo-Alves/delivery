<?php

namespace App\Http\Controllers\Produto;

use App\Models\Categoria;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProdutoController extends Controller
{
    public function produtos_categorias($id_categoria){
        $categoria = Categoria::find($id_categoria);

        $produtos = $categoria->produtos;

        return response()->json($produtos,200);
    }
}
