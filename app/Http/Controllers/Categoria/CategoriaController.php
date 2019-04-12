<?php

namespace App\Http\Controllers\Categoria;

use App\Models\Categoria;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoriaController extends Controller
{
    public function categorias(){
        $categorias = Categoria::all();

        return response()->json(['result' => 'success', 'categorias' => $categorias]);
    }
}
