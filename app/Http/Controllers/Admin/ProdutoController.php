<?php

namespace App\Http\Controllers\Admin;

use App\Models\Categoria;
use App\Models\Produto;
use App\Repositories\ImageRepository;
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

    public function produtos_categoria($id_categoria){
        $user = Auth::user();
        $categoria = Categoria::find($id_categoria);

        $produtos = $categoria->produtos;

        return response()->json($produtos,200);
    }

    public function categorias(){
        $user = Auth::user();
        $empresa = $user->empresa;
        $categorias = $empresa->categorias;
        return response()->json($categorias,200);
    }

    public function put(Request $request){
        //$user = Auth::user();
        $data = [
            'id_categoria' => $request->categoria,
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'valor' => $request->valor,
        ];
        $produto = Produto::create($data);

        if(empty($produto)){
            return response()->json(['result' => 'error'], 500);
        }else{
            $repo = new ImageRepository();

            if ($request->hasFile('primaryImage')) {
                $produto->imagem = $repo->saveImage($request->primaryImage, $produto->id_produto, 'produtos', 250);
                $produto->save();
            }
        }

        return redirect()->action('Admin\ProdutoController@index');
        //return response()->json(['result' => 'success', 'produto' => $produto], 200);
    }
}
