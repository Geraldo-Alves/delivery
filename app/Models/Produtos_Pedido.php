<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produtos_Pedido extends Model
{
    protected $table = 'produtos_pedido';
    protected $primaryKey = null;
    public $incrementing = false;

    protected $fillable = [
        'id_pedido', 'id_produto', 'qtd',
    ];
}
