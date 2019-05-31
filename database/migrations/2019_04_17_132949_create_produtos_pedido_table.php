<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdutosPedidoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos_pedido', function (Blueprint $table) {
            $table->integer('id_produto')->unsigned();
            $table->integer('id_pedido')->unsigned();
            $table->integer('qtd');
            $table->timestamps();

            $table->foreign('id_produto')
                ->references('id_produto')->on('produto')
                ->onDelete('cascade');

            $table->foreign('id_pedido')
                ->references('id_pedido')->on('pedido')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produtos_pedido');
    }
}
