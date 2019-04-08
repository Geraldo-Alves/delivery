<?php

namespace App\Http\Controllers\Admin;

use App\Models\Empresa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EmpresaController extends Controller
{
    public function index(Request $request){
        $user = Auth::user();
        $empresa = $user->empresa;
        return view('admin.empresa')->with(['empresa' => $empresa]);
    }

    public function create(Request $request){
        return view('admin.empresa_create');
    }

    public function put(Request $request){
        $id_user = Auth::id();
        $data = [
            'id_admin' => $id_user,
            'cnpj' => $request->cnpj,
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'logo' => $request->logo,
        ];

        $empresa = Empresa::where('cnpj', $request->cnpj)->first();
        if(!empty($empresa)){
            $empresa->nome = $request->nome;
            $empresa->descricao = $request->descricao;
            $empresa->logo= $request->logo;
            $empresa->save();
        }else{
            $empresa = Empresa::updateOrCreate($data);
        }

        return redirect()->action('Admin\EmpresaController@index');
        //return response()->json(['result' => 'success', 'empresa' => $empresa], 200);
    }
}
