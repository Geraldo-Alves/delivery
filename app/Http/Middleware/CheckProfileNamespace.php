<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckProfileNamespace
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public $user;

    public function handle($request, Closure $next)
    {
        // Obtêm o usuário que está logado
        $this->user = Auth::user();
        $profile = $this->user->profile;

        // Obtêm o namespace solicitado
        $namespace = explode('/', $request->getPathInfo())[1];

        // Se o namespace for equivalente ao perfil, deixa passar a requisição
        if($profile == $namespace){
            return $next($request);
            // Caso não seja, redireciona para a view de acesso restrito
        }else{
            return response(view('restrict'));
        }

    }
}
