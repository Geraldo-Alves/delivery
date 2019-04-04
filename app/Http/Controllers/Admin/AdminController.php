<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $request){
        $user = Auth::user();
        $empresa = $user->empresa;
        if(!empty($empresa)){
            return view('admin.dashboard')->with(['empresa' => $empresa]);
        }else{
            return redirect()->action('Admin\EmpresaController@create');
        }
    }
}
