<?php

namespace App\Http\Controllers\Cliente;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ClienteController extends Controller
{
    public function index(){
        $user = Auth::user();
    }
}
