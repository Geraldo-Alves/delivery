<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'pedido';
    protected $primaryKey = 'id_pedido';

    protected $fillable = [
        'id_usuario', 'total', 'qtd_produtos', 'status', 'endereco', 'latitude', 'longitude'
    ];

    // Recupera a relacao produto / pedido pelo id do produto
    public function produto_pedido($id_produto){
        return $this->hasMany(Produtos_Pedido::class, 'id_pedido', 'id_pedido')->where('produtos_pedido.id_produto', '=', $id_produto)->first();
    }

    // Recupera o produto pelo id
    public function produto($id_produto){
        return $this->hasManyThrough(Produto::class, Produtos_Pedido::class, 'id_pedido', 'id_produto', 'id_pedido', 'id_produto')->where('produto.id_produto', '=', $id_produto)->first();
    }

    public function produtos(){
        return $this->hasManyThrough(Produto::class, Produtos_Pedido::class, 'id_pedido', 'id_produto', 'id_pedido', 'id_produto');
    }

    public function cliente(){
        return $this->belongsTo(User::class, 'id_usuario', 'id');
    }
}
