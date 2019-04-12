<?php

namespace App\Http\Controllers\Admin;

use App\Models\Categoria;
use App\Repositories\ImageRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CategoriaController extends Controller
{
    public function index(Request $request){
        $user = Auth::user();
        $empresa = $user->empresa;
        $categorias = $empresa->categorias;
        return view('admin.categoria_produtos')->with(['categorias' => $categorias]);
    }

    public function put(Request $request){
        $user = Auth::user();
        $empresa = $user->empresa;

        $data = [
            'id_empresa' => $empresa->id_empresa,
            'nome' => $request->nome,
            'descricao' => $request->descricao,
        ];

        $categoria = Categoria::create($data);

        if(empty($categoria)){
            return response()->json(['result' => 'error'], 500);
        }else{
            $repo = new ImageRepository();

            if ($request->hasFile('primaryImage')) {
                $categoria->imagem = $repo->saveImage($request->primaryImage, $categoria->id_categoria, 'categorias', 250);
                $categoria->save();
            }
        }

        return redirect()->action('Admin\ProdutoController@index');
        //return response()->json(['result' => 'success', 'produto' => $produto], 200);
    }
}
