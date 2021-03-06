<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdutoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produto', function (Blueprint $table) {
            $table->increments('id_produto');
            $table->integer('id_categoria')->unsigned();
            $table->string('nome');
            $table->double('valor');
            $table->string('descricao');
            $table->string('imagem')->nullable();
            $table->timestamps();

            $table->foreign('id_categoria')
                ->references('id_categoria')->on('categoria')
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
        Schema::dropIfExists('produto');
    }
}
