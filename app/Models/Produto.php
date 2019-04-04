<?php

namespace App\Models;


class Produto
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_produto', 'id_categoria', 'valor', 'descricao'
    ];
}
