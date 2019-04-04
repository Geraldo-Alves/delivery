<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categoria';
    protected $primaryKey = 'id_categoria';

    protected $fillable = [
      'id_empresa', 'nome'
    ];

    public function produtos(){
        return $this->hasMany(Produto::class, 'id_categoria', 'id_categoria');
    }
}
