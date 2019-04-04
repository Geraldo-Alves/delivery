<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{

    protected $primaryKey = 'id_empresa';
    protected $table = 'empresa';

    protected $fillable = [
        'id_empresa', 'cnpj', 'nome', 'descricao', 'logo', 'id_admin'
    ];

    public function admin(){
        return $this->belongsTo(User::class,'id_admin', 'id')->first();
    }

    public function categorias(){
        return $this->hasMany(Categoria::class, 'id_empresa', 'id_empresa');
    }
}
