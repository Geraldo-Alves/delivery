<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{

    protected $table = 'produto';
    protected $primaryKey = 'id_produto';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome', 'id_categoria', 'valor', 'descricao', 'imagem',
    ];
}
